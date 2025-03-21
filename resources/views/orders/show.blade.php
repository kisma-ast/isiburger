@extends('layouts.app')

@section('title', 'Détails de la commande #' . $order->id)

@section('content')
    <div class="container py-4">
        <!-- En-tête avec statut proéminent -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center gap-3">
                        <div class="position-relative">
                            @switch($order->status)
                                @case('en_attente')
                                    <div class="status-icon bg-warning">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    @break
                                @case('en_preparation')
                                    <div class="status-icon bg-info">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                    @break
                                @case('prete')
                                    <div class="status-icon bg-success">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    @break
                                @case('payee')
                                    <div class="status-icon bg-primary">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    @break
                                @default
                                    <div class="status-icon bg-secondary">
                                        <i class="fas fa-question"></i>
                                    </div>
                            @endswitch
                        </div>
                        <div>
                            <h1 class="fs-3 mb-0">Commande #{{ $order->id }}</h1>
                            <div class="text-muted">
                                {{ $order->created_at->format('d/m/Y H:i') }} • {{ $order->user->name }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>

                        @if($order->status === 'prete' || $order->status === 'payee')
                            <a href="{{ route('orders.invoice', $order) }}" class="btn btn-primary ms-2">
                                <i class="fas fa-file-pdf me-2"></i>Télécharger la facture
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Barre de progression -->
            <div class="order-progress">
                <div class="progress-line">
                    <div class="progress-step {{ in_array($order->status, ['en_attente', 'en_preparation', 'prete', 'payee']) ? 'completed' : '' }}">
                        <div class="step-icon"><i class="fas fa-receipt"></i></div>
                        <div class="step-label">Reçue</div>
                    </div>
                    <div class="progress-step {{ in_array($order->status, ['en_preparation', 'prete', 'payee']) ? 'completed' : '' }}">
                        <div class="step-icon"><i class="fas fa-utensils"></i></div>
                        <div class="step-label">En préparation</div>
                    </div>
                    <div class="progress-step {{ in_array($order->status, ['prete', 'payee']) ? 'completed' : '' }}">
                        <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="step-label">Prête</div>
                    </div>
                    <div class="progress-step {{ $order->status === 'payee' ? 'completed' : '' }}">
                        <div class="step-icon"><i class="fas fa-money-check"></i></div>
                        <div class="step-label">Payée</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Détails de la commande -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Détails de la commande</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th class="text-end pe-4">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($item->burger && $item->burger->image)
                                                    <div class="rounded overflow-hidden me-3">
                                                        <img src="{{ asset('storage/' . $item->burger->image) }}" alt="{{ $item->burger->name }}" class="product-img">
                                                    </div>
                                                @else
                                                    <div class="product-placeholder me-3">
                                                        <i class="fas fa-hamburger"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->burger ? $item->burger->name : 'Burger indisponible' }}</h6>
                                                    @if($item->burger && $item->burger->description)
                                                        <small class="text-muted d-block">{{ Str::limit($item->burger->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->price, 2) }} CFA</td>
                                        <td>
                                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end pe-4 fw-semibold">{{ number_format($item->price * $item->quantity, 2) }} CFA</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-4 bg-light">
                            <div class="row justify-content-end">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between py-2">
                                        <span>Total HT</span>
                                        <span>{{ number_format($order->total_amount / 1.2, 2) }} CFA</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-2">
                                        <span>TVA (20%)</span>
                                        <span>{{ number_format($order->total_amount - ($order->total_amount / 1.2), 2) }} CFA</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-2 border-top mt-2 pt-2">
                                        <span class="fw-bold">Total TTC</span>
                                        <span class="fw-bold fs-5">{{ number_format($order->total_amount, 2) }} CFA</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panneau latéral -->
            <div class="col-lg-4">
                <!-- Informations de commande -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Informations</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <span class="text-muted"><i class="far fa-calendar-alt me-2"></i>Date de commande</span>
                                <span class="fw-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </li>
                            <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <span class="text-muted"><i class="far fa-user me-2"></i>Client</span>
                                <span class="fw-medium">{{ $order->user->name }}</span>
                            </li>
                            <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                                <span class="text-muted"><i class="fas fa-tag me-2"></i>Statut</span>
                                @switch($order->status)
                                    @case('en_attente')
                                        <span class="badge bg-warning rounded-pill px-3 py-2">En attente</span>
                                        @break
                                    @case('en_preparation')
                                        <span class="badge bg-info rounded-pill px-3 py-2">En préparation</span>
                                        @break
                                    @case('prete')
                                        <span class="badge bg-success rounded-pill px-3 py-2">Prête</span>
                                        @break
                                    @case('payee')
                                        <span class="badge bg-primary rounded-pill px-3 py-2">Payée</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $order->status }}</span>
                                @endswitch
                            </li>
                            @if($order->payment)
                                <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                                    <span class="text-muted"><i class="far fa-clock me-2"></i>Date de paiement</span>
                                    <span class="fw-medium">{{ $order->payment->created_at->format('d/m/Y H:i') }}</span>
                                </li>
                                <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                                    <span class="text-muted"><i class="fas fa-credit-card me-2"></i>Méthode de paiement</span>
                                    <span class="fw-medium">Espèces</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Actions pour gestionnaires -->
                @if(Auth::user()->isGestionnaire())
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Actions</h5>
                        </div>
                        <div class="card-body">
                            @if($order->status !== 'payee')
                                <form action="{{ route('orders.status.update', $order) }}" method="POST" class="mb-3">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Mettre à jour le statut</label>
                                        <select name="status" id="status" class="form-select form-select-lg">
                                            <option value="en_attente" {{ $order->status === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                            <option value="en_preparation" {{ $order->status === 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                                            <option value="prete" {{ $order->status === 'prete' ? 'selected' : '' }}>Prête</option>
                                            @if($order->status === 'prete')
                                                <option value="payee">Payée</option>
                                            @endif
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-sync-alt me-2"></i>Mettre à jour
                                    </button>
                                </form>

                                @if($order->status === 'prete' && !$order->payment)
                                    <a href="{{ route('payments.create', $order) }}" class="btn btn-success btn-lg w-100 mb-3">
                                        <i class="fas fa-money-bill-wave me-2"></i>Enregistrer un paiement
                                    </a>
                                @endif

                                <button type="button" class="btn btn-outline-danger btn-lg w-100" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                    <i class="fas fa-times-circle me-2"></i>Annuler la commande
                                </button>

                                <!-- Modal de confirmation -->
                                <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmer l'annulation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Êtes-vous sûr de vouloir annuler cette commande ?</p>
                                                <p class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Cette action est irréversible.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Confirmer l'annulation</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-success d-flex align-items-center shadow-sm border-0">
                                    <i class="fas fa-check-circle fs-4 me-3"></i>
                                    <div>
                                        <strong>Commande payée</strong>
                                        <div>Le {{ $order->payment->created_at->format('d/m/Y à H:i') }}</div>
                                    </div>
                                </div>
                                <div class="alert alert-info d-flex align-items-center mt-3 shadow-sm border-0">
                                    <i class="fas fa-info-circle fs-4 me-3"></i>
                                    <div>Aucune action supplémentaire n'est possible pour une commande payée.</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- CSS supplémentaire pour le redesign -->
    <style>
        .status-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-placeholder {
            width: 60px;
            height: 60px;
            background-color: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 1.5rem;
        }

        .order-progress {
            padding: 0 1.5rem 1.5rem;
        }

        .progress-line {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 0 1rem;
        }

        .progress-line::before {
            content: '';
            position: absolute;
            height: 3px;
            background-color: #e9ecef;
            top: 25px;
            left: 0;
            right: 0;
            z-index: 1;
        }

        .progress-step {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 50px;
        }

        .step-icon {
            width: 50px;
            height: 50px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            color: #6c757d;
        }

        .progress-step.completed .step-icon {
            background-color: #198754;
            color: white;
        }

        .step-label {
            font-size: 0.75rem;
            white-space: nowrap;
        }

    </style>
@endsection
