@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center min-vh-100 align-items-center py-5">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="text-center mb-4">
                    <!-- Logo ou nom d'application peut être ajouté ici -->
                    <h1 class="h3 mb-2">Connexion</h1>
                    <p class="text-muted">Accédez à votre compte</p>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium">{{ __('Adresse e-mail') }}</label>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                    <input id="email" type="email"
                                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}"
                                           required autocomplete="email" autofocus
                                           placeholder="exemple@email.com">
                                </div>
                                @error('email')
                                <span class="text-danger small mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-medium mb-0">{{ __('Mot de passe') }}</label>
                                    @if (Route::has('password.request'))
                                        <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                            {{ __('Mot de passe oublié?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                    <input id="password" type="password"
                                           class="form-control border-start-0 @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="current-password"
                                           placeholder="••••••••">
                                </div>
                                @error('password')
                                <span class="text-danger small mt-1">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Se souvenir de moi') }}
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-2">
                                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('Connexion') }}
                                </button>
                            </div>

                            <!-- Optionnel: lien pour créer un compte -->
                            <div class="text-center mt-4">
                                <p class="mb-0 text-muted">Pas encore de compte?
                                    <a href="{{ route('register') }}" class="text-decoration-none">Créer un compte</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
