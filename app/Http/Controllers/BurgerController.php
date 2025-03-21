<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    public function index(Request $request)
    {
        $query = Burger::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $burgers = $query->latest()->paginate(10);

        return view('burgers.index', compact('burgers'));
    }

    public function create()
    {
        return view('burgers.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('burgers', 'public');
            $validatedData['image'] = $imagePath;
        }

        Burger::create($validatedData);

        return redirect()->route('burgers.index')
            ->with('success', 'Burger créé avec succès.');
    }

    public function show(Burger $burger)
    {
        return view('burgers.show', compact('burger'));
    }

    public function edit(Burger $burger)
    {
        return view('burgers.edit', compact('burger'));
    }

    public function update(Request $request, Burger $burger)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($burger->image) {
                Storage::disk('public')->delete($burger->image);
            }
            $imagePath = $request->file('image')->store('burgers', 'public');
            $validatedData['image'] = $imagePath;
        }

        $burger->update($validatedData);

        return redirect()->route('burgers.index')
            ->with('success', 'Burger mis à jour avec succès.');
    }

    public function archive(Burger $burger)
    {
        $burger->update(['is_archived' => true]);

        return redirect()->route('burgers.index')
            ->with('success', 'Burger archivé avec succès.');
    }

    public function destroy(Burger $burger)
    {
        if ($burger->orderItems()->count() > 0) {
            return redirect()->route('burgers.index')
                ->with('error', 'Impossible de supprimer ce burger car il est associé à des commandes.');
        }

        if ($burger->image) {
            Storage::disk('public')->delete($burger->image);
        }

        $burger->delete();

        return redirect()->route('burgers.index')
            ->with('success', 'Burger supprimé avec succès.');
    }

    public function catalog(Request $request)
    {
        $query = Burger::available();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $burgers = $query->latest()->paginate(12);

        return view('burgers.catalog', compact('burgers'));
    }
}