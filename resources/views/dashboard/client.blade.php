@extends('layouts.app')

@section('title', 'Tableau de bord client')

@section('content')
    <div class="container py-4">
        <!-- En-tête avec salutation et statut -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle bg-primary text-white me-3 d-flex align-items-center justify-content-center">
                        <span class="h4 mb-0">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="h3 fw-bold mb-0">Bienvenue, {{ Auth::user()->name }}</h1>
                        <p class="text-muted mb-0">Votre espace personnel</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-md-end align-items-center mt-3 mt-md-0">
                    <a href="{{ route('burgers.catalog') }}" class="btn btn-primary me-2">
                        <i class="fas fa-hamburger me-2"></i> Commander
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-dark position-relative">
                        <i class="fas fa-shopping-cart me-1"></i> Panier
                        @if(session()->has('cart') && count(session('cart')) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ count(session('cart')) }}
                            <span class="visually-hidden">produits dans votre panier</span>
                        </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Cartes d'informations -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape bg-success bg-opacity-10 text-success rounded p-3 me-3">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase fw-semibold mb-1">Commandes</h6>
                                <h3 class="fw-bold mb-0">{{ count($userOrders) }}</h3>
                            </div>
                        </div>
                        <p class="text-muted">Total de vos commandes</p>
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-success mt-auto">
                            <i class="fas fa-history me-1"></i> Historique
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded p-3 me-3">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase fw-semibold mb-1">Statut</h6>
                                <h3 class="fw-bold mb-0">Client</h3>
                            </div>
                        </div>
                        <p class="text-muted">Votre statut de fidélité</p>
                        <div class="progress mt-auto mb-2" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 25%"></div>
                        </div>
                        <small class="text-muted">5 commandes avant le niveau Silver</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 bg-primary bg-gradient text-white">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape bg-white text-primary rounded p-3 me-3">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase fw-semibold mb-1 text-white-50">Offre spéciale</h6>
                                <h3 class="fw-bold mb-0">10% de remise</h3>
                            </div>
                        </div>
                        <p>Sur votre prochaine commande avec le code <strong>WELCOME10</strong></p>
                        <a href="{{ route('burgers.catalog') }}" class="btn btn-light text-primary mt-auto">
                            <i class="fas fa-hamburger me-1"></i> Commander maintenant
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Dernières commandes -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold">Vos dernières commandes</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="orderFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-1"></i> Filtrer
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="orderFilterDropdown">
                                <li><a class="dropdown-item" href="#">Toutes les commandes</a></li>
                                <li><a class="dropdown-item" href="#">En attente</a></li>
                                <li><a class="dropdown-item" href="#">En préparation</a></li>
                                <li><a class="dropdown-item" href="#">Prêtes</a></li>
                                <li><a class="dropdown-item" href="#">Payées</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body px-0 py-0">
                        @if(count($userOrders) > 0)
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 text-uppercase small fw-bold">ID</th>
                                        <th class="text-uppercase small fw-bold">Date</th>
                                        <th class="text-uppercase small fw-bold">Total</th>
                                        <th class="text-uppercase small fw-bold">Statut</th>
                                        <th class="text-uppercase small fw-bold text-end pe-4">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($userOrders as $order)
                                        <tr>
                                            <td class="ps-4 fw-bold">
                                                #{{ $order->id }}
                                            </td>
                                            <td>
                                                <span>{{ $order->created_at->format('d/m/Y') }}</span>
                                                <div class="small text-muted">{{ $order->created_at->format('H:i') }}</div>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ number_format($order->total_amount, 2) }} CFA</span>
                                            </td>
                                            <td>
                                                @switch($order->status)
                                                    @case('en_attente')
                                                        <span class="badge rounded-pill bg-warning text-dark">En attente</span>
                                                        @break
                                                    @case('en_preparation')
                                                        <span class="badge rounded-pill bg-info">En préparation</span>
                                                        @break
                                                    @case('prete')
                                                        <span class="badge rounded-pill bg-success">Prête</span>
                                                        @break
                                                    @case('payee')
                                                        <span class="badge rounded-pill bg-primary">Payée</span>
                                                        @break
                                                    @default
                                                        <span class="badge rounded-pill bg-secondary">{{ $order->status }}</span>
                                                @endswitch
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group">
                                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Voir les détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($order->status === 'prete' || $order->status === 'payee')
                                                        <a href="{{ route('orders.invoice', $order) }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Télécharger la facture">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>
                                                    @endif
                                                    @if($order->status === 'en_attente')
                                                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Suivre ma commande">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3">
                                <div class="text-muted small">Affichage des {{ count($userOrders) }} dernières commandes</div>
                                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">
                                    Voir tout l'historique <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info m-3 d-flex align-items-center">
                                <i class="fas fa-info-circle fs-4 me-3"></i>
                                <div>
                                    <p class="mb-0">Vous n'avez pas encore passé de commande.</p>
                                    <a href="{{ route('burgers.catalog') }}" class="btn btn-sm btn-primary mt-2">
                                        Commander maintenant
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne de droite -->
            <div class="col-lg-4">
                <!-- Actions rapides -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Actions rapides</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('burgers.catalog') }}" class="btn btn-primary d-flex align-items-center justify-content-between p-3">
                            <span>
                                <i class="fas fa-hamburger me-2"></i> Commander un burger
                            </span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-dark d-flex align-items-center justify-content-between p-3">
                            <span>
                                <i class="fas fa-shopping-cart me-2"></i> Voir mon panier
                                @if(session()->has('cart') && count(session('cart')) > 0)
                                    <span class="badge rounded-pill bg-danger ms-2">{{ count(session('cart')) }}</span>
                                @endif
                            </span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-between p-3">
                            <span>
                                <i class="fas fa-user-edit me-2"></i> Modifier mon profil
                            </span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Burgers populaires -->
                @if(count($availableBurgers) > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <h5 class="mb-0 fw-bold">Burgers populaires</h5>
                            <a href="{{ route('burgers.catalog') }}" class="btn btn-sm btn-light">
                                Voir tout
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach($availableBurgers as $burger)
                                    <li class="list-group-item p-3 border-start-0 border-end-0">
                                        <div class="d-flex align-items-center">
                                            @if($burger->image)
                                                <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->name }}" class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-3 text-center me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <i class="fas fa-hamburger text-secondary"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <a href="{{ route('burgers.show', $burger) }}" class="text-decoration-none">
                                                    <h6 class="mb-1 fw-bold">{{ $burger->name }}</h6>
                                                </a>
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="text-warning me-2">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                    </div>
                                                    <span class="text-muted small">4.5/5</span>
                                                </div>
                                                <p class="fw-bold text-dark mb-0">{{ number_format($burger->price, 2) }} CFA</p>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Ajouter au panier">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Widget météo -->
                <div class="card border-0 shadow-sm bg-light mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 fw-bold">Météo locale</h5>
                            <div class="fs-3 text-primary">
                                <i class="fas fa-sun"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="display-4 fw-bold me-2">28°</div>
                            <div>
                                <p class="mb-0">Ensoleillé</p>
                                <p class="text-muted mb-0 small">Dakar, Sénégal</p>
                            </div>
                        </div>
                        <p class="mt-2 mb-0 small text-muted">Parfait pour manger un burger en terrasse !</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 24px;
        }

        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    @section('scripts')
        <script>
            // Initialiser les tooltips Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        </script>
    @endsection
@endsection
