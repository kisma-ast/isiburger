@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center min-vh-100 align-items-center py-5">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="text-center mb-4">
                    <h1 class="h3 mb-2">Créer un compte</h1>
                    <p class="text-muted">Complétez le formulaire pour vous inscrire</p>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label fw-medium">{{ __('Nom') }}</label>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                    <input id="name" type="text"
                                           class="form-control border-start-0 @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}"
                                           required autocomplete="name" autofocus
                                           placeholder="Votre nom complet">
                                </div>
                                @error('name')
                                <span class="text-danger small mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium">{{ __('Adresse e-mail') }}</label>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                    <input id="email" type="email"
                                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}"
                                           required autocomplete="email"
                                           placeholder="exemple@email.com">
                                </div>
                                @error('email')
                                <span class="text-danger small mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-medium">{{ __('Mot de passe') }}</label>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                    <input id="password" type="password"
                                           class="form-control border-start-0 @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="new-password"
                                           placeholder="8 caractères minimum">
                                </div>
                                @error('password')
                                <span class="text-danger small mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span>
                                @enderror
                                <div class="form-text small mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Le mot de passe doit contenir au moins 8 caractères
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-medium">{{ __('Confirmer le mot de passe') }}</label>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                    <input id="password-confirm" type="password"
                                           class="form-control border-start-0"
                                           name="password_confirmation" required autocomplete="new-password"
                                           placeholder="Saisissez à nouveau votre mot de passe">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                    <label class="form-check-label small" for="terms">
                                        J'accepte les <a href="#" class="text-decoration-none">conditions d'utilisation</a> et la <a href="#" class="text-decoration-none">politique de confidentialité</a>
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-2">
                                    <i class="fas fa-user-plus me-2"></i>{{ __('Créer mon compte') }}
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="mb-0 text-muted">Vous avez déjà un compte?
                                    <a href="{{ route('login') }}" class="text-decoration-none">Se connecter</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
