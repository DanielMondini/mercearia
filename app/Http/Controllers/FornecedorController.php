<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    // Lista os fornecedores
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return view('fornecedores.index', compact('fornecedores'));
    }

    // Exibe o formulário de criação de fornecedor
    public function create()
    {
        return view('fornecedores.create');
    }

    // Salva um novo fornecedor
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        Fornecedor::create($request->all());

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor criado com sucesso!');
    }

    // Exibe o formulário de edição de fornecedor
    public function edit(Fornecedor $fornecedor)
    {
        return view('fornecedores.edit', compact('fornecedor'));
    }

    // Atualiza um fornecedor existente
    public function update(Request $request, Fornecedor $fornecedor)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        $fornecedor->update($request->all());

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    // Remove um fornecedor
    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor excluído com sucesso!');
    }
}
