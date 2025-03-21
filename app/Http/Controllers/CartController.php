<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'burger_id' => 'required|exists:burgers,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $burger = Burger::findOrFail($request->burger_id);

       
        if (!$burger->isInStock() || $burger->is_archived) {
            return back()->with('error', 'Ce burger n\'est pas disponible.');
        }

        if ($burger->stock < $request->quantity) {
            return back()->with('error', 'La quantité demandée n\'est pas disponible.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$burger->id])) {
            $newQuantity = $cart[$burger->id]['quantity'] + $request->quantity;
            
            if ($burger->stock < $newQuantity) {
                return back()->with('error', 'La quantité totale demandée dépasse le stock disponible.');
            }
            
            $cart[$burger->id]['quantity'] = $newQuantity;
        } else {
            $cart[$burger->id] = [
                'name' => $burger->name,
                'quantity' => $request->quantity,
                'price' => $burger->price,
                'image' => $burger->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Burger ajouté au panier.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'burger_id' => 'required|exists:burgers,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $burger = Burger::findOrFail($request->burger_id);
        
        if ($burger->stock < $request->quantity) {
            return back()->with('error', 'La quantité demandée n\'est pas disponible.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->burger_id])) {
            $cart[$request->burger_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Panier mis à jour.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'burger_id' => 'required|exists:burgers,id'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->burger_id])) {
            unset($cart[$request->burger_id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Panier vidé.');
    }
}