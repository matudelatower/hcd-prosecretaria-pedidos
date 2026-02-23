<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    public function index()
    {
        $edificios = Edificio::with('oficinas')->get();
        return view('admin.edificios.index', compact('edificios'));
    }

    public function create()
    {
        return view('admin.edificios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Edificio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.edificios.index')
            ->with('success', 'Edificio creado correctamente.');
    }

    public function show(Edificio $edificio)
    {
        return view('admin.edificios.show', compact('edificio'));
    }

    public function edit(Edificio $edificio)
    {
        return view('admin.edificios.edit', compact('edificio'));
    }

    public function update(Request $request, Edificio $edificio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $edificio->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.edificios.index')
            ->with('success', 'Edificio actualizado correctamente.');
    }

    public function destroy(Edificio $edificio)
    {
        $edificio->delete();
        return redirect()->route('admin.edificios.index')
            ->with('success', 'Edificio eliminado correctamente.');
    }
}
