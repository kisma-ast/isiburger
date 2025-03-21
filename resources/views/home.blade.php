@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Tableau de bord</h1>
            <span class="text-muted">{{ date('d/m/Y') }}</span>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success border-0 shadow-sm" role="alert">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div>
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Bienvenue</h5>
                                <p class="text-muted mb-0">{{ __('Vous êtes connecté avec succès!') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte de raccourcis rapides -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Accès rapide</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="#" class="text-decoration-none">
                                    <div class="card border-0 bg-light h-100">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-clipboard-list text-primary mb-3 fa-2x"></i>
                                            <h6 class="mb-0">Commandes</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="text-decoration-none">
                                    <div class="card border-0 bg-light h-100">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-burger text-success mb-3 fa-2x"></i>
                                            <h6 class="mb-0">Produits</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="text-decoration-none">
                                    <div class="card border-0 bg-light h-100">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-chart-bar text-info mb-3 fa-2x"></i>
                                            <h6 class="mb-0">Statistiques</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
