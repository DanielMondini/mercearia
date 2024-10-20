<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Exibe a lista de itens
    public function index()
    {
        $itens = Item::all();
        return view('itens.index', compact('itens'));
    }

    // Exibe o formulário de criação de item
    public function create()
    {
        return view('itens.create');
    }

    // Salva um novo item
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'unidade_medida' => 'required',
            'quantidade' => 'required|integer',
        ]);

        Item::create($request->all());

        return redirect()->route('itens.index')->with('success', 'Item criado com sucesso!');
    }

    // Exibe o formulário de edição de item
    public function edit(Item $item)
    {
        return view('itens.edit', compact('item'));
    }

    // Atualiza um item existente
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'nome' => 'required',
            'unidade_medida' => 'required',
            'quantidade' => 'required|integer',
        ]);

        $item->update($request->all());

        return redirect()->route('itens.index')->with('success', 'Item atualizado com sucesso!');
    }

    // Remove um item
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('itens.index')->with('success', 'Item excluído com sucesso!');
    }
}
