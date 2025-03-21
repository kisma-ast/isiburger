<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function create(Order $order)
    {
        if (!Auth::user()->isGestionnaire()) {
            abort(403, 'Accès non autorisé.');
        }

        if ($order->status !== 'prete') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Seules les commandes prêtes peuvent être payées.');
        }

        if ($order->payment) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Cette commande a déjà été payée.');
        }

        return view('payments.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if (!Auth::user()->isGestionnaire()) {
            abort(403, 'Accès non autorisé.');
        }

        if ($order->status !== 'prete') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Seules les commandes prêtes peuvent être payées.');
        }

        if ($order->payment) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Cette commande a déjà été payée.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:' . $order->total_amount,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'amount' => $request->amount,
            'method' => 'especes',
        ]);

        $order->update([
            'status' => 'payee'
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Le paiement a été enregistré avec succès.');
    }
}