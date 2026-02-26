<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::whereNull('deleted_at')->get();
        return view('admin.areas.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.areas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        Area::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->activo ?? true,
        ]);

        return redirect()->route('admin.areas.index')
            ->with('success', 'Área creada correctamente.');
    }

    public function show(Area $area)
    {
        return view('admin.areas.show', compact('area'));
    }

    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        $area->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'activo' => $request->activo ?? true,
        ]);

        return redirect()->route('admin.areas.index')
            ->with('success', 'Área actualizada correctamente.');
    }

    public function destroy(Area $area)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()
                ->with('error', 'No autorizado. Solo los administradores pueden eliminar registros.');
        }
        
        $area->delete();
        return redirect()->route('admin.areas.index')
            ->with('success', 'Área eliminada correctamente.');
    }
}
