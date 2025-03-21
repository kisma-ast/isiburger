# Étape 1 : Image de base PHP avec les extensions nécessaires
FROM php:8.2-apache

# Étape 2 : Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    default-mysql-client \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd zip bcmath

# Étape 3 : Activation des modules Apache nécessaires
RUN a2enmod rewrite

# Étape 4 : Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 5 : Configuration du répertoire de travail
WORKDIR /var/www

# Étape 6 : Copie des fichiers Laravel
COPY . .

# Étape 7 : Installation des dépendances PHP avec Composer
RUN composer install --no-dev --optimize-autoloader

# Étape 8 : Droits sur le stockage et le cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Étape 9 : Configuration du Document Root pour Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN if [ ! -f /var/www/.env ]; then \
        cp /var/www/.env.example /var/www/.env || touch /var/www/.env; \
    fi

# Étape 11 : Configuration des permissions pour www-data
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Étape 12 : Activer les logs d'erreurs pour le débogage
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/custom.ini

# Étape 13 : Commande de démarrage
CMD ["apache2-foreground"]

EXPOSE 80
