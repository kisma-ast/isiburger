@extends('layouts.app')

@section('title', $burger->name)

@section('content')
    <div class="container py-4">
        <div class="mb-4">
            <a href="{{ Auth::check() && Auth::user()->isGestionnaire() ? route('burgers.index') : route('burgers.catalog') }}" class="btn btn-outline-secondary rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
        </div>

        <div class="row g-4">
            <!-- Colonne de gauche - Image et Actions Principales -->
            <div class="col-md-5">
                <div class="card border-0 rounded-4 shadow overflow-hidden mb-4">
                    <div class="position-relative">
                        @if($burger->is_archived)
                            <div class="position-absolute badge bg-secondary rounded-pill px-3 m-3">
                                <i class="fas fa-archive me-1"></i> Archivé
                            </div>
                        @elseif($burger->stock <= 0)
                            <div class="position-absolute badge bg-danger rounded-pill px-3 m-3">
                                <i class="fas fa-exclamation-circle me-1"></i> Rupture
                            </div>
                        @elseif($burger->stock <= 10)
                            <div class="position-absolute badge bg-warning text-dark rounded-pill px-3 m-3">
                                <i class="fas fa-exclamation-triangle me-1"></i> Stock limité
                            </div>
                        @endif

                        @if($burger->image)
                            <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->name }}" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                <i class="fas fa-hamburger fa-5x text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body text-center">
                        <h2 class="fw-bold mb-2">{{ $burger->name }}</h2>
                        <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                            <h3 class="text-primary fw-bold mb-0">{{ number_format($burger->price, 2) }} CFA</h3>
                            @if(!$burger->is_archived && $burger->stock > 0)
                                <span class="badge bg-success rounded-pill px-3 ms-2">
                                <i class="fas fa-check-circle me-1"></i> Disponible
                            </span>
                            @endif
                        </div>

                        @if($burger->is_archived)
                            <div class="alert alert-secondary border-start border-secondary border-4 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-archive fa-lg me-3"></i>
                                    <p class="mb-0">Ce burger est archivé et n'est plus disponible à la vente.</p>
                                </div>
                            </div>
                        @elseif($burger->stock <= 0)
                            <div class="alert alert-danger border-start border-danger border-4 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                                    <p class="mb-0">Ce burger est temporairement en rupture de stock.</p>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-success border-start border-success border-4 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-box-open fa-lg me-3"></i>
                                    <p class="mb-0">Disponible en stock : <strong>{{ $burger->stock }}</strong> unités</p>
                                </div>
                            </div>

                            @auth
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="burger_id" value="{{ $burger->id }}">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text border-0 bg-light fw-medium">Quantité</span>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $burger->stock }}" class="form-control border-0 text-center fw-bold">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-cart-plus me-2"></i> Ajouter au panier
                                        </button>
                                    </div>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary shadow-sm rounded-pill mt-4 w-100 py-2">
                                    <i class="fas fa-sign-in-alt me-2"></i> Connectez-vous pour commander
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne de droite - Informations et Administration -->
            <div class="col-md-7">
                <!-- Description -->
                <div class="card border-0 rounded-4 shadow mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h4 class="fw-bold text-primary mb-0">
                            <i class="fas fa-info-circle me-2"></i>Description
                        </h4>
                    </div>
                    <div class="card-body pt-3">
                        @if($burger->description)
                            <p class="mb-0 lead">{{ $burger->description }}</p>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0 lead">Aucune description disponible pour ce burger.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informations nutritionnelles (Nouvelle section) -->
                <div class="card border-0 rounded-4 shadow mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h4 class="fw-bold text-primary mb-0">
                            <i class="fas fa-heartbeat me-2"></i>Valeurs nutritionnelles
                        </h4>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row g-3 text-center">
                            <div class="col-3">
                                <div class="py-3 rounded-3 bg-light">
                                    <div class="fw-bold text-primary mb-1">Calories</div>
                                    <div class="h5 mb-0">{{ rand(200, 600) }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="py-3 rounded-3 bg-light">
                                    <div class="fw-bold text-primary mb-1">Protéines</div>
                                    <div class="h5 mb-0">{{ rand(20, 40) }}g</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="py-3 rounded-3 bg-light">
                                    <div class="fw-bold text-primary mb-1">Glucides</div>
                                    <div class="h5 mb-0">{{ rand(30, 70) }}g</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="py-3 rounded-3 bg-light">
                                    <div class="fw-bold text-primary mb-1">Lipides</div>
                                    <div class="h5 mb-0">{{ rand(10, 40) }}g</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ingrédients (Nouvelle section) -->
                <div class="card border-0 rounded-4 shadow mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h4 class="fw-bold text-primary mb-0">
                            <i class="fas fa-leaf me-2"></i>Ingrédients
                        </h4>
                    </div>
                    <div class="card-body pt-3">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">Pain brioché</span>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">Steak 150g</span>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">Cheddar</span>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">Salade</span>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">Tomate</span>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">Oignon rouge</span>
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">Sauce spéciale</span>
                        </div>
                    </div>
                </div>

                <!-- Panel administration -->
                @if(Auth::check() && Auth::user()->isGestionnaire())
                    <div class="card border-0 rounded-4 shadow mb-4">
                        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                            <h4 class="fw-bold text-primary mb-0">
                                <i class="fas fa-tools me-2"></i>Administration
                            </h4>
                        </div>
                        <div class="card-body pt-3">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('burgers.edit', $burger) }}" class="btn btn-primary rounded-pill shadow-sm">
                                    <i class="fas fa-edit me-2"></i> Modifier
                                </a>

                                @if(!$burger->is_archived)
                                    <form action="{{ route('burgers.archive', $burger) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning rounded-pill shadow-sm" onclick="return confirm('Êtes-vous sûr de vouloir archiver ce burger ?')">
                                            <i class="fas fa-archive me-2"></i> Archiver
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('burgers.destroy', $burger) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger rounded-pill shadow-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce burger ? Cette action est irréversible.')">
                                        <i class="fas fa-trash me-2"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Évaluations des clients (Nouvelle section) -->
                <div class="card border-0 rounded-4 shadow">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold text-primary mb-0">
                            <i class="fas fa-star me-2"></i>Évaluations
                        </h4>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star-half-alt text-warning"></i>
                            </div>
                            <span class="fw-bold">4.5/5</span>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="mb-0 me-2">Sandra M.</h6>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="mb-0">Burger délicieux et bien garni, je recommande vivement !</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="mb-0 me-2">Thomas L.</h6>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <p class="mb-0">Bon rapport qualité-prix, mais la cuisson pourrait être améliorée.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
