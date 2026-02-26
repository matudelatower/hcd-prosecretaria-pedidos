<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Oficina;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('oficina')->whereNull('deleted_at')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $oficinas = Oficina::whereNull('deleted_at')->get();
        $roles = Role::where('activo', true)->whereNull('deleted_at')->get();
        return view('admin.users.create', compact('oficinas', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'oficina_id' => 'nullable|exists:oficinas,id',
            'activo' => 'boolean',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'oficina_id' => $request->oficina_id,
            'activo' => $request->activo ?? true,
        ]);

        $user->roles()->attach($request->roles);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $oficinas = Oficina::whereNull('deleted_at')->get();
        $roles = Role::where('activo', true)->whereNull('deleted_at')->get();
        return view('admin.users.edit', compact('user', 'oficinas', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'oficina_id' => 'nullable|exists:oficinas,id',
            'activo' => 'boolean',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'oficina_id' => $request->oficina_id,
            'activo' => $request->activo ?? true,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->back()
                ->with('error', 'No autorizado. Solo los administradores pueden eliminar registros.');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
