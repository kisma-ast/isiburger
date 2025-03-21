@extends('layouts.app')

@section('title', 'Panier')

@section('content')
<div class="container">
    <h1 class="mb-4">Mon panier</h1>

    @if(count($cart) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Articles dans votre panier</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                        <th class="text-end">Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if(isset($item['image']) && $item['image'])
                                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light text-center me-2" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-hamburger text-muted" style="line-height: 50px;"></i>
                                                        </div>
                                                    @endif
                                                    <span>{{ $item['name'] }}</span>
                                                </div>
                                            </td>
                                            <td>{{ number_format($item['price'], 2) }} CFA</td>
                                            <td>
                                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="burger_id" value="{{ $id }}">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm" style="width: 60px;">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-end">{{ number_format($item['price'] * $item['quantity'], 2) }} CFA</td>
                                            <td>
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="burger_id" value="{{ $id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Récapitulatif</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                Sous-total
                                <span>{{ number_format($totalPrice, 2) }} CFA</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                TVA (20%)
                                <span>{{ number_format($totalPrice * 0.2, 2) }} CFA</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 fw-bold">
                                <div class="text-uppercase">Total</div>
                                <span>{{ number_format($totalPrice, 2) }} CFA</span>
                            </li>
                        </ul>

                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-check"></i> Valider ma commande
                            </button>
                        </form>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('burgers.catalog') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Continuer les achats
                            </a>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i> Vider le panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <p>Votre panier est vide.</p>
            <a href="{{ route('burgers.catalog') }}" class="btn btn-primary mt-2">
                <i class="fas fa-shopping-basket"></i> Parcourir le catalogue
            </a>
        </div>
    @endif
</div>
@endsection
