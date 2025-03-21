@extends('layouts.app')

@section('title', 'Enregistrer un paiement')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Enregistrer un paiement pour la commande #{{ $order->id }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info mb-4 shadow-sm">
                            <h6 class="fw-bold">Résumé de la commande</h6>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><i class="fas fa-user me-2"></i> <strong>Client:</strong> {{ $order->user->name }}</p>
                                    <p><i class="fas fa-calendar me-2"></i> <strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><i class="fas fa-money-bill me-2"></i> <strong>Montant total:</strong>
                                        <span class="badge bg-success fs-6">{{ number_format($order->total_amount, 2) }} CFA</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('payments.store', $order) }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="amount" class="form-label fw-bold">Montant payé (CFA) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                    <input type="number" step="0.01" min="{{ $order->total_amount }}" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', $order->total_amount) }}" required>
                                    <span class="input-group-text">CFA</span>
                                </div>
                                <div class="form-text text-muted"><i class="fas fa-info-circle me-1"></i> Le montant doit être au moins égal au total de la commande.</div>
                                @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Méthode de paiement</label>
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="method" id="methodCash" value="especes" checked>
                                            <label class="form-check-label" for="methodCash">
                                                <i class="fas fa-money-bill-wave me-2 text-success"></i> Espèces
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-circle me-2"></i> Confirmer le paiement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
