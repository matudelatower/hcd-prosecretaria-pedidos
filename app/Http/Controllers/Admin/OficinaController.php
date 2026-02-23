<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edificio;
use App\Models\Oficina;
use Illuminate\Http\Request;

class OficinaController extends Controller
{
    public function index()
    {
        $oficinas = Oficina::with('edificio')->get();
        return view('admin.oficinas.index', compact('oficinas'));
    }

    public function create()
    {
        $edificios = Edificio::all();
        return view('admin.oficinas.create', compact('edificios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'edificio_id' => 'required|exists:edificios,id',
        ]);

        Oficina::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'edificio_id' => $request->edificio_id,
        ]);

        return redirect()->route('admin.oficinas.index')
            ->with('success', 'Oficina creada correctamente.');
    }

    public function show(Oficina $oficina)
    {
        return view('admin.oficinas.show', compact('oficina'));
    }

    public function edit(Oficina $oficina)
    {
        $edificios = Edificio::all();
        return view('admin.oficinas.edit', compact('oficina', 'edificios'));
    }

    public function update(Request $request, Oficina $oficina)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'edificio_id' => 'required|exists:edificios,id',
        ]);

        $oficina->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'edificio_id' => $request->edificio_id,
        ]);

        return redirect()->route('admin.oficinas.index')
            ->with('success', 'Oficina actualizada correctamente.');
    }

    public function destroy(Oficina $oficina)
    {
        $oficina->delete();
        return redirect()->route('admin.oficinas.index')
            ->with('success', 'Oficina eliminada correctamente.');
    }
}
