<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->isGestionnaire()) {
            return $this->gestionnaireIndex();
        } else {
            return $this->clientIndex();
        }
    }

    private function gestionnaireIndex()
    {
        $totalUsers = User::where('role', 'client')->count();
        $totalBurgers = Burger::count();
        $pendingOrders = Order::whereIn('status', ['en_attente', 'en_preparation'])->count();
        $totalOrders = Order::count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('dashboard.gestionnaire', compact(
            'totalUsers',
            'totalBurgers',
            'pendingOrders',
            'totalOrders',
            'recentOrders'
        ));
    }

    private function clientIndex()
    {
        $user = Auth::user();
        $userOrders = $user->orders()->latest()->take(5)->get();
        $availableBurgers = Burger::available()->take(4)->get();

        return view('dashboard.client', compact(
            'userOrders',
            'availableBurgers'
        ));
    }
}