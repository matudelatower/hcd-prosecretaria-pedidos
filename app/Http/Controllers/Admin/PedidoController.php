<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Pedido;
use App\Models\Solicitante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with(['solicitadoPor', 'areaDestino'])->whereNull('deleted_at');

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('expediente')) {
            $query->where('numero_expediente', 'like', '%' . $request->expediente . '%');
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_solicitud', $request->fecha);
        }

        if ($request->filled('area_id')) {
            $query->where('area_destino_id', $request->area_id);
        }

        $pedidos = $query->orderBy('created_at', 'desc')->paginate(10);
        $areas = Area::where('activo', true)->whereNull('deleted_at')->get();
        $usuarios = User::where('activo', true)->whereNull('deleted_at')->get();

        return view('admin.pedidos.index', compact('pedidos', 'areas', 'usuarios'));
    }

    public function create()
    {
        $areas = Area::where('activo', true)->whereNull('deleted_at')->get();
        $usuarios = User::where('activo', true)->whereNull('deleted_at')->get();
        return view('admin.pedidos.create', compact('areas', 'usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_expediente' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
            'fecha_solicitud' => 'required|date',
            'solicitado_por_id' => 'required|exists:solicitantes,id',
            'area_destino_id' => 'required|exists:areas,id',
            'observaciones' => 'nullable|string',
        ]);

        Pedido::create([
            'numero_expediente' => $request->numero_expediente,
            'descripcion' => $request->descripcion,
            'fecha_solicitud' => $request->fecha_solicitud,
            'solicitado_por_id' => $request->solicitado_por_id,
            'area_destino_id' => $request->area_destino_id,
            'observaciones' => $request->observaciones,
            'estado' => 'solicitado',
        ]);

        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido creado correctamente.');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['solicitadoPor', 'solicitadoPorUsuario', 'areaDestino', 'recibidoPor', 'enviadoPor', 'recibidoDestinoPor', 'recibidoDestinoPorUsuario']);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $pedido->load(['solicitadoPor', 'solicitadoPorUsuario', 'areaDestino']);
        $areas = Area::where('activo', true)->whereNull('deleted_at')->get();
        $usuarios = User::where('activo', true)->whereNull('deleted_at')->get();
        return view('admin.pedidos.edit', compact('pedido', 'areas', 'usuarios'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'numero_expediente' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
            'fecha_solicitud' => 'required|date',
            'area_destino_id' => 'required|exists:areas,id',
            'fecha_recepcion' => 'nullable|date',
            'recibido_por' => 'nullable|exists:users,id',
            'fecha_envio' => 'nullable|date',
            'enviado_por' => 'nullable|exists:users,id',
            'recibido_destino_por_id' => 'nullable|exists:solicitantes,id',
            'recibido_destino_por_usuario' => 'nullable|exists:users,id',
            'fecha_recibido_destino' => 'nullable|date',
            'estado' => 'required|in:solicitado,recibido,enviado,entregado,completado',
            'observaciones' => 'nullable|string',
        ]);

        $pedido->update($request->except(['solicitado_por_id']));

        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $pedido)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()
                ->with('error', 'No autorizado. Solo los administradores pueden eliminar registros.');
        }
        
        $pedido->delete();
        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }

    // Acciones de estado
    public function recibir(Request $request, Pedido $pedido)
    {
        $request->validate([
            'recibido_por' => 'required|exists:users,id',
            'fecha_recepcion' => 'required|date',
        ]);

        $pedido->update([
            'recibido_por' => $request->recibido_por,
            'fecha_recepcion' => $request->fecha_recepcion,
            'estado' => 'recibido',
        ]);

        return redirect()->route('admin.pedidos.show', $pedido)
            ->with('success', 'Pedido recibido correctamente.');
    }

    public function enviar(Request $request, Pedido $pedido)
    {
        $request->validate([
            'enviado_por' => 'required|exists:users,id',
            'fecha_envio' => 'required|date',
        ]);

        $pedido->update([
            'enviado_por' => $request->enviado_por,
            'fecha_envio' => $request->fecha_envio,
            'estado' => 'enviado',
        ]);

        return redirect()->route('admin.pedidos.show', $pedido)
            ->with('success', 'Pedido enviado correctamente.');
    }

    public function entregar(Request $request, Pedido $pedido)
    {
        $request->validate([
            'recibido_destino_por_id' => 'nullable|exists:solicitantes,id',
            'recibido_destino_por_usuario' => 'nullable|exists:users,id',
            'fecha_recibido_destino' => 'nullable|date',
        ]);

        $pedido->update([
            'recibido_destino_por_id' => $request->recibido_destino_por_id,
            'recibido_destino_por_usuario' => $request->recibido_destino_por_usuario,
            'fecha_recibido_destino' => $request->fecha_recibido_destino,
            'estado' => 'entregado',
        ]);

        return redirect()->route('admin.pedidos.show', $pedido)
            ->with('success', 'Pedido entregado correctamente.');
    }

    public function completar(Pedido $pedido)
    {
        $pedido->update(['estado' => 'completado']);

        return redirect()->route('admin.pedidos.show', $pedido)
            ->with('success', 'Pedido completado correctamente.');
    }
}
