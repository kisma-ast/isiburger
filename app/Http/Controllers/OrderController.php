<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OrderReady;
use App\Mail\OrderConfirmation;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Log;
use App\Models\User;



class OrderController extends Controller
{
    public function index()
    {
        if (Auth::user()->isGestionnaire()) {
            $orders = Order::with('user')->latest()->paginate(10);
        } else {
            $orders = Auth::user()->orders()->latest()->paginate(10);
        }

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (Auth::user()->isClient() && $order->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette commande.');
        }

        $order->load('items.burger', 'user', 'payment');

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('burgers.catalog')
                ->with('error', 'Votre panier est vide.');
        }

        // Verifier les stocks
        foreach ($cart as $id => $item) {
            $burger = Burger::find($id);
            if (!$burger || $burger->stock < $item['quantity']) {
                return redirect()->route('cart.index')
                    ->with('error', 'Le burger ' . ($burger ? $burger->name : '') . ' n\'est plus disponible en quantité suffisante.');
            }
        }

        // Crer la commande
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'en_attente',
            'total_amount' => $totalAmount
        ]);

        foreach ($cart as $id => $item) {
            $burger = Burger::find($id);

            OrderItem::create([
                'order_id' => $order->id,
                'burger_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            $burger->update([
                'stock' => $burger->stock - $item['quantity']
            ]);
        }

        session()->forget('cart');

        try {
            Mail::to(Auth::user()->email)->send(new OrderConfirmation($order));

            $this->notifyManager($order);
        } catch (\Exception $e) {
            \Log::error('Email error: ' . $e->getMessage());
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Votre commande a été passée avec succès.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:en_attente,en_preparation,prete,payee'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status' => $newStatus
        ]);

        if ($newStatus === 'prete' && $oldStatus !== 'prete') {
            try {
                $pdf = PDF::loadView('pdf.invoice', ['order' => $order]);

                Mail::to($order->user->email)->send(new OrderReady($order, $pdf));

                \Log::info('Facture envoyée pour la commande #' . $order->id . ' à ' . $order->user->email);
            } catch (\Exception $e) {
                \Log::error('Erreur lors de l\'envoi de la facture pour la commande #' . $order->id . ': ' . $e->getMessage());
            }
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Statut de la commande mis à jour avec succès.');
    }


    private function sendInvoiceEmail($order)
    {
        try {
            $pdf = PDF::loadView('pdf.invoice', ['order' => $order]);

            Mail::to($order->user->email)->send(new OrderReady($order, $pdf));
        } catch (\Exception $e) {
            \Log::error('Failed to send invoice email: ' . $e->getMessage());
        }
    }

    public function generateInvoice(Order $order)
    {
        if (Auth::user()->isClient() && $order->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $pdf = PDF::loadView('pdf.invoice', ['order' => $order]);
        return $pdf->download('facture-' . $order->id . '.pdf');
    }

    private function notifyManager(Order $order)
    {
        $managers = User::where('role', 'gestionnaire')->get();

        foreach ($managers as $manager) {
            $manager->notify(new NewOrderNotification($order));
        }
    }
}
