<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Mail\OrderReady;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestMailController extends Controller
{
    public function testOrderConfirmation()
    {
        $order = Order::with(['user', 'items.burger'])->first();
        
        if (!$order) {
            return 'Aucune commande trouvée pour le test';
        }
        
        try {
            Mail::to($order->user->email)->send(new OrderConfirmation($order));
            return 'Email de confirmation envoyé avec succès à ' . $order->user->email;
        } catch (\Exception $e) {
            return 'Erreur: ' . $e->getMessage();
        }
    }
    
    public function testOrderReady()
    {
        $order = Order::with(['user', 'items.burger'])->first();
        
        if (!$order) {
            return 'Aucune commande trouvée pour le test';
        }
        
        try {
            $pdf = PDF::loadView('pdf.invoice', ['order' => $order]);
            Mail::to($order->user->email)->send(new OrderReady($order, $pdf));
            return 'Email avec facture envoyé avec succès à ' . $order->user->email;
        } catch (\Exception $e) {
            return 'Erreur: ' . $e->getMessage();
        }
    }
}