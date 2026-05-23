<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
public function index(Request $request)
{
    $buscar = $request->input('buscar'); 
    $perPage = $request->input('per_page', 10); 

    $roles = Role::query()
        ->when($buscar, function($query, $buscar) {
            $query->where('name', 'like', "%{$buscar}%");
        })
        ->orderBy('id', 'asc')
        ->paginate($perPage)
        ->withQueryString(); 

    return view('roles.index', compact('roles', 'buscar', 'perPage'));
}

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate(['name' => 'required|unique:roles,name,'.$role->id]);
        $role->update(['name' => $request->name]);
        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function permissions(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.permissions', compact('role', 'permissions'));
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $permissionIds = $request->permissions ?? [];
        $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Permisos actualizados correctamente.');
    }
      public function destroy(Role $role)
    {
        if ($role->name === 'Admin') {
            return redirect()->route('roles.index')
                             ->with('error', 'No se puede eliminar el rol Admin.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}

