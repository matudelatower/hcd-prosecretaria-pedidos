<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solicitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitanteController extends Controller
{
    public function index()
    {
        $solicitantes = Solicitante::whereNull('deleted_at')->orderBy('nombre')->get();
        return view('admin.solicitantes.index', compact('solicitantes'));
    }

    public function create()
    {
        return view('admin.solicitantes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:solicitantes,nombre',
            'cargo' => 'nullable|string|max:255',
            'dependencia' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        Solicitante::create($request->all());

        return redirect()->route('admin.solicitantes.index')
            ->with('success', 'Solicitante creado correctamente.');
    }

    public function show(Solicitante $solicitante)
    {
        $solicitante->load(['pedidosSolicitados', 'pedidosRecibidosDestino']);
        return view('admin.solicitantes.show', compact('solicitante'));
    }

    public function edit(Solicitante $solicitante)
    {
        return view('admin.solicitantes.edit', compact('solicitante'));
    }

    public function update(Request $request, Solicitante $solicitante)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:solicitantes,nombre,' . $solicitante->id,
            'cargo' => 'nullable|string|max:255',
            'dependencia' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        $solicitante->update($request->all());

        return redirect()->route('admin.solicitantes.index')
            ->with('success', 'Solicitante actualizado correctamente.');
    }

    public function destroy(Solicitante $solicitante)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()
                ->with('error', 'No autorizado. Solo los administradores pueden eliminar registros.');
        }
        
        // Verificar si tiene pedidos asociados
        if ($solicitante->pedidosSolicitados->count() > 0 || $solicitante->pedidosRecibidosDestino->count() > 0) {
            return redirect()->route('admin.solicitantes.index')
                ->with('error', 'No se puede eliminar el solicitante porque tiene pedidos asociados.');
        }

        $solicitante->delete();

        return redirect()->route('admin.solicitantes.index')
            ->with('success', 'Solicitante eliminado correctamente.');
    }

    // API para autocompletado
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $solicitantes = Solicitante::activos()
            ->where(function($q) use ($query) {
                $q->where('nombre', 'like', "%{$query}%")
                  ->orWhere('cargo', 'like', "%{$query}%")
                  ->orWhere('dependencia', 'like', "%{$query}%");
            })
            ->orderBy('nombre')
            ->limit(10)
            ->get(['id', 'nombre', 'cargo', 'dependencia']);

        return response()->json($solicitantes);
    }

    // Método para crear solicitante desde modal
    public function storeQuick(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:solicitantes,nombre',
            'cargo' => 'nullable|string|max:255',
            'dependencia' => 'nullable|string|max:255',
        ]);

        $solicitante = Solicitante::create($request->all());

        return response()->json([
            'success' => true,
            'solicitante' => $solicitante
        ]);
    }
}
