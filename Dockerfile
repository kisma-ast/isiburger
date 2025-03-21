# 1️⃣ Utilisation de l'image officielle PHP avec les extensions nécessaires
FROM php:8.2-fpm

# 2️⃣ Installation des dépendances du système
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# 3️⃣ Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4️⃣ Définition du répertoire de travail
WORKDIR /var/www

# 5️⃣ Copie des fichiers de l'application
COPY . .

# 6️⃣ Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# 7️⃣ Permissions pour Laravel
RUN chmod -R 775 storage bootstrap/cache

# 8️⃣ Copie du fichier d'environnement et génération de la clé
RUN cp .env.example .env && php artisan key:generate

# 9️⃣ Configuration de Nginx
RUN apt-get install -y nginx
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# 🔟 Supervisor pour gérer les processus (queue workers, schedule, etc.)
RUN apt-get install -y supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# 1️⃣1️⃣ Exposition des ports
EXPOSE 80

# 1️⃣2️⃣ Commande de démarrage
CMD ["sh", "-c", "php artisan migrate --force && supervisord -n"]
