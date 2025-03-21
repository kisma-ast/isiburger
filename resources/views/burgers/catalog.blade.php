@extends('layouts.app')

@section('title', 'Saveurs Urbaines - Collection de Burgers')

@section('content')
    <div class="container-fluid px-4 py-5">
        <!-- Hero Section -->
        <div class="position-relative mb-5 rounded-4 overflow-hidden">
            <div class="bg-dark text-white p-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/burger-hero.jpg') }}') center/cover no-repeat;">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold mb-3">Explorez nos Créations</h1>
                        <p class="lead mb-4">Chaque bouchée raconte une histoire de saveurs authentiques et d'ingrédients sélectionnés avec passion.</p>
                        <form action="{{ route('burgers.catalog') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-lg" name="search" placeholder="Que recherchez-vous ?" value="{{ request('search') }}">
                                <button class="btn btn-warning px-4" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Filter Pills -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('burgers.catalog') }}" class="btn {{ !request('category') ? 'btn-warning' : 'btn-outline-dark' }} rounded-pill">
                Tous
            </a>
            <a href="{{ route('burgers.catalog', ['category' => 'classic']) }}" class="btn {{ request('category') == 'classic' ? 'btn-warning' : 'btn-outline-dark' }} rounded-pill">
                Classiques
            </a>
            <a href="{{ route('burgers.catalog', ['category' => 'signature']) }}" class="btn {{ request('category') == 'signature' ? 'btn-warning' : 'btn-outline-dark' }} rounded-pill">
                Signatures
            </a>
            <a href="{{ route('burgers.catalog', ['category' => 'veggie']) }}" class="btn {{ request('category') == 'veggie' ? 'btn-warning' : 'btn-outline-dark' }} rounded-pill">
                Végétariens
            </a>
        </div>

        <!-- Advanced Filter (Collapsible) -->
        <div class="mb-4">
            <button class="btn btn-outline-dark d-flex align-items-center gap-2 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                <i class="fas fa-sliders-h"></i> Filtres avancés
                @if(request('search') || request('min_price') || request('max_price'))
                    <span class="badge bg-warning rounded-pill">Actifs</span>
                @endif
            </button>
            <div class="collapse {{ (request('search') || request('min_price') || request('max_price')) ? 'show' : '' }}" id="filterCollapse">
                <div class="card card-body border-0 shadow-sm rounded-4">
                    <form action="{{ route('burgers.catalog') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Nom du burger</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-burger"></i></span>
                                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="min_price" class="form-label">Prix minimum</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                <input type="number" step="0.01" class="form-control" id="min_price" name="min_price" value="{{ request('min_price') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="max_price" class="form-label">Prix maximum</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="number" step="0.01" class="form-control" id="max_price" name="max_price" value="{{ request('max_price') }}">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-grid gap-2 w-100">
                                <button type="submit" class="btn btn-warning">Appliquer</button>
                                @if(request('search') || request('min_price') || request('max_price'))
                                    <a href="{{ route('burgers.catalog') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Count and Sort -->
        @if($burgers->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0 text-muted">{{ $burgers->total() }} résultats trouvés</p>
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-sort"></i> Trier par
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('burgers.catalog', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}">Prix croissant</a></li>
                        <li><a class="dropdown-item" href="{{ route('burgers.catalog', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}">Prix décroissant</a></li>
                        <li><a class="dropdown-item" href="{{ route('burgers.catalog', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}">Nouveautés</a></li>
                        <li><a class="dropdown-item" href="{{ route('burgers.catalog', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}">Popularité</a></li>
                    </ul>
                </div>
            </div>

            <!-- Burger Grid -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
                @foreach($burgers as $burger)
                    <div class="col">
                        <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm hover-shadow transition-all">
                            <div class="position-relative">
                                @if($burger->image)
                                    <img src="{{ asset('storage/' . $burger->image) }}" class="card-img-top" alt="{{ $burger->name }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light text-center py-5">
                                        <i class="fas fa-hamburger fa-4x text-muted"></i>
                                    </div>
                                @endif

                                <!-- Stock badge overlay -->
                                @if($burger->stock <= 0)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-danger p-2">Rupture de stock</span>
                                    </div>
                                @elseif($burger->stock <= 5)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-warning text-dark p-2">Stock limité</span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold mb-0">{{ $burger->name }}</h5>
                                    <span class="badge bg-warning text-dark rounded-pill">Nouveau</span>
                                </div>

                                <p class="card-text text-muted mb-3 flex-grow-1">{{ Str::limit($burger->description, 80) }}</p>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fs-4 fw-bold text-warning">{{ number_format($burger->price, 0) }} CFA</span>
                                    <span class="text-muted small">Stock: {{ $burger->stock }}</span>
                                </div>

                                <div class="d-grid gap-2">
                                    @auth
                                        <form action="{{ route('cart.add') }}" method="POST" class="d-grid">
                                            @csrf
                                            <input type="hidden" name="burger_id" value="{{ $burger->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-warning" {{ $burger->stock <= 0 ? 'disabled' : '' }}>
                                                <i class="fas fa-cart-plus me-2"></i> Ajouter au panier
                                            </button>
                                        </form>
                                        <a href="{{ route('burgers.show', $burger) }}" class="btn btn-outline-dark">Voir les détails</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-warning">
                                            <i class="fas fa-sign-in-alt me-2"></i> Se connecter pour commander
                                        </a>
                                        <a href="{{ route('burgers.show', $burger) }}" class="btn btn-outline-dark">Voir les détails</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination with Custom Styling -->
            <nav aria-label="Pagination des burgers" class="my-5">
                <ul class="pagination justify-content-center">
                    {{ $burgers->onEachSide(1)->links() }}
                </ul>
            </nav>
        @else
            <div class="text-center py-5 my-5">
                <img src="{{ asset('images/empty-plate.svg') }}" alt="Aucun résultat" class="img-fluid mb-4" style="max-width: 150px;">
                <h3 class="text-muted">Aucun burger ne correspond à vos critères</h3>
                <p class="text-muted mb-4">Essayez de modifier vos filtres pour obtenir plus de résultats.</p>
                <a href="{{ route('burgers.catalog') }}" class="btn btn-outline-warning btn-lg">
                    <i class="fas fa-redo me-2"></i> Réinitialiser les filtres
                </a>
            </div>
        @endif

        <!-- Featured Sections -->
        <section class="my-5 py-4">
            <h3 class="text-center mb-4">Pourquoi choisir nos burgers ?</h3>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="card border-0 h-100 rounded-4 shadow-sm p-4">
                        <div class="card-body">
                            <div class="icon-circle bg-warning-subtle mb-3 mx-auto">
                                <i class="fas fa-leaf fa-2x text-warning"></i>
                            </div>
                            <h5>Ingrédients Frais</h5>
                            <p class="text-muted">Nous sélectionnons quotidiennement les meilleurs produits locaux pour nos recettes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 h-100 rounded-4 shadow-sm p-4">
                        <div class="card-body">
                            <div class="icon-circle bg-warning-subtle mb-3 mx-auto">
                                <i class="fas fa-utensils fa-2x text-warning"></i>
                            </div>
                            <h5>Fait Maison</h5>
                            <p class="text-muted">Nos chefs préparent chaque composant de nos burgers de façon artisanale.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 h-100 rounded-4 shadow-sm p-4">
                        <div class="card-body">
                            <div class="icon-circle bg-warning-subtle mb-3 mx-auto">
                                <i class="fas fa-truck fa-2x text-warning"></i>
                            </div>
                            <h5>Livraison Rapide</h5>
                            <p class="text-muted">Nous garantissons une livraison en moins de 30 minutes pour préserver toutes les saveurs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- CSS additions -->
    <style>
        .icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.2);
        }
    </style>
@endsection
