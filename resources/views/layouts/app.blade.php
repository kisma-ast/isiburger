<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER - @yield('title', 'Accueil')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #ff6b6b;
            --primary-dark: #ff5252;
            --secondary: #ffd166;
            --dark: #2d3436;
            --light: #f8f9fa;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: var(--dark);
        }

        main {
            flex: 1;
        }

        /* Header styling */
        .navbar {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            padding: 15px 0;
            border-bottom: 3px solid var(--primary);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--primary) !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
        }

        .navbar-brand::after {
            content: "🍔";
            position: absolute;
            font-size: 1.2rem;
            top: -10px;
            right: -20px;
            transform: rotate(15deg);
        }

        .nav-link {
            font-weight: 600;
            padding: 8px 15px !important;
            margin: 0 5px;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background-color: rgba(255, 107, 107, 0.1);
            color: var(--primary) !important;
            transform: translateY(-2px);
        }

        /* Buttons styling */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 25px;
            padding: 8px 25px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
        }

        /* Cards styling */
        .card {
            border-radius: 15px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 30px rgba(255, 107, 107, 0.15);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-weight: 700;
            color: var(--primary);
        }

        /* Badge styling */
        .badge {
            padding: 6px 10px;
            border-radius: 12px;
            font-weight: 600;
        }

        /* Shopping cart icon animation */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .cart-icon:hover {
            animation: bounce 0.5s infinite;
            color: var(--primary);
        }

        /* Footer styling */
        footer {
            background: linear-gradient(135deg, var(--dark) 0%, #1e272e 100%);
            padding: 40px 0 30px;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary), var(--primary));
        }

        footer h5 {
            font-weight: 700;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        footer h5::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 40px;
            height: 3px;
            background-color: var(--primary);
        }

        /* Alert styling */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .alert-success {
            background-color: #d4edda;
            border-left: 5px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-left: 5px solid #dc3545;
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: none;
            padding: 10px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 8px 15px;
            margin: 2px 0;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 107, 107, 0.1);
            color: var(--primary);
        }

        /* Custom container width for better readability */
        @media (min-width: 1400px) {
            .container {
                max-width: 1200px;
            }
        }

        /* Add burger pattern to background */
        main::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ff6b6b' fill-opacity='0.03' fill-rule='evenodd'%3E%3Cpath d='M20 0a20 20 0 1 0 0 40 20 20 0 0 0 0-40zm0 30a10 10 0 1 1 0-20 10 10 0 0 1 0 20z'/%3E%3C/g%3E%3C/svg%3E");
            z-index: -1;
        }
    </style>
    @yield('styles')
</head>
<body>
<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('burgers.catalog') }}">|S|BURGER</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('burgers.catalog') }}">
                        <i class="fas fa-burger me-1"></i> Catalogue
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            <i class="fas fa-receipt me-1"></i> Commandes
                        </a>
                    </li>
                    @if(Auth::user()->isGestionnaire())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('burgers.index') }}">
                                <i class="fas fa-cog me-1"></i> Gestion Burgers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('statistics.index') }}">
                                <i class="fas fa-chart-bar me-1"></i> Statistiques
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart cart-icon me-1"></i>
                            Panier
                            @if(session()->has('cart') && count(session('cart')) > 0)
                                <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Tableau de bord</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i> Inscription</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<main class="py-5">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<!-- Pied de page -->
<footer class="text-white mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>ISI BURGER</h5>
                <p>Le meilleur des burgers, préparés avec passion !</p>
                <div class="mt-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>CONTACT</h5>
                <p><i class="fas fa-map-marker-alt me-2"></i> 123 Avenue des Gourmets</p>
                <p><i class="fas fa-phone me-2"></i> (01) 23 45 67 89</p>
                <p class="mb-3"><i class="fas fa-envelope me-2"></i> contact@isiburger.com</p>
                <p>&copy; {{ date('Y') }} ISI BURGER. Tous droits réservés.</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Script allégé sans animations de disparition
    document.addEventListener('DOMContentLoaded', function() {
        // Aucune animation de disparition/apparition des cartes
        console.log('ISI Burger chargé avec succès');
    });
</script>
@yield('scripts')
</body>
</html>
