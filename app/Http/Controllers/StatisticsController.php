<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;

class StatisticsController extends Controller
{
    public function index()
    {
        // Commandes en cours de la jj
        $todayOrders = Order::whereDate('created_at', Carbon::today())
            ->whereIn('status', ['en_attente', 'en_preparation'])
            ->count();

        // les commandes valide
        $validatedOrders = Order::whereDate('created_at', Carbon::today())
            ->whereIn('status', ['prete', 'payee'])
            ->count();

        // vente de la journee
        $dailyRevenue = Payment::whereDate('created_at', Carbon::today())
            ->sum('amount');

        // Nombre de commandes par mois pour les 12 derniers mois
        $ordersByMonth = Order::select(
            DB::raw('EXTRACT(MONTH FROM created_at) as month'),
            DB::raw('EXTRACT(YEAR FROM created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(12))
        ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at)'), DB::raw('EXTRACT(MONTH FROM created_at)'))
        ->orderBy(DB::raw('EXTRACT(YEAR FROM created_at)'))
        ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
        ->get();

        // formatage
        $months = [];
        $orderCounts = [];

        foreach ($ordersByMonth as $data) {
            $months[] = Carbon::createFromDate($data->year, $data->month, 1)->format('M Y');
            $orderCounts[] = $data->count;
        }

    // Prod par cat
        $burgersSold = OrderItem::select(
            'burger_id',
            DB::raw('EXTRACT(MONTH FROM created_at) as month'),
            DB::raw('EXTRACT(YEAR FROM created_at) as year'),
            DB::raw('SUM(quantity) as total')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(12))
        ->groupBy('burger_id', DB::raw('EXTRACT(YEAR FROM created_at)'), DB::raw('EXTRACT(MONTH FROM created_at)'))
        ->orderBy(DB::raw('EXTRACT(YEAR FROM created_at)'))
        ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
        ->with('burger:id,name')
        ->get();

        $burgerData = [];

        foreach ($burgersSold as $sale) {
            $monthYear = Carbon::createFromDate($sale->year, $sale->month, 1)->format('M Y');

            if (!isset($burgerData[$sale->burger->name])) {
                $burgerData[$sale->burger->name] = [];
            }

            $burgerData[$sale->burger->name][$monthYear] = $sale->total;
        }

        return view('statistics.index', compact(
            'todayOrders',
            'validatedOrders',
            'dailyRevenue',
            'months',
            'orderCounts',
            'burgerData'
        ));
    }
}
