<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
   public function index(Request $request)
{
    $perPage = $request->get('per_page', 10);
    $buscar = $request->get('buscar');

    $permissions = Permission::when($buscar, function ($query, $buscar) {
        return $query->where('name', 'like', "%$buscar%");
    })
    ->orderBy('id', 'asc')
    ->paginate($perPage);

    return view('permisos.index', compact('permissions'));
}


    public function create()
    {
        return view('permisos.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return redirect()->route('permisos.index')->with('success', 'Permiso creado correctamente.');
    }

public function edit($id)
{
    $permission = Permission::findOrFail($id);
    return view('permisos.edit', compact('permission')); 
}
public function update(Request $request, $id)
{
    $permission = Permission::findOrFail($id);

    $request->validate([
        'name' => 'required|unique:permissions,name,' . $permission->id,
    ]);

    $permission->update([
        'name' => $request->name,
    ]);

    return redirect()->route('permisos.index')->with('success', 'Permiso actualizado correctamente.');
}

public function destroy($id)
{
    $permission = Permission::findOrFail($id);
    $permission->delete();

    return redirect()->route('permisos.index')->with('success', 'Permiso eliminado correctamente.');
}


}
