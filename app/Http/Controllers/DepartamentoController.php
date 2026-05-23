<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    
    public function index()
    {
        $departamentos = Departamento::orderBy('id', 'desc')->paginate(10);
        return view('departamento.index', compact('departamentos'));
    }

    public function create()
    {
        return view('departamento.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'departamento' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:departamento,codigo',
        ]);

        Departamento::create([
            'departamento' => $request->departamento,
            'codigo' => $request->codigo,
            'usuario_reg' => auth()->user()->name ?? 'sistema',
            'registrado' => now(),
        ]);

        return redirect()->route('departamento.index')->with('success', 'Departamento registrado correctamente.');
    }

    /**
     * Muestra el formulario para editar un departamento.
     */
    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('departamento.edit', compact('departamento'));
    }

    /**
     * Actualiza la información del departamento.
     */
    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);

        $request->validate([
            'departamento' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:departamento,codigo,' . $departamento->id,
        ]);

        $departamento->update([
            'departamento' => $request->departamento,
            'codigo' => $request->codigo,
            'modificado' => now(),
            'usuario_mod' => auth()->user()->name ?? 'sistema',
        ]);

        return redirect()->route('departamento.index')->with('success', 'Departamento actualizado correctamente.');
    }

    /**
     * Elimina un departamento.
     */
    public function destroy($id)
    {
        Departamento::destroy($id);
        return redirect()->route('departamento.index')->with('success', 'Departamento eliminado correctamente.');
    }
}

