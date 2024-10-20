<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $itens = Item::with('cotacoes.fornecedor')->get();

        $melhoresCotas = [];

        foreach ($itens as $item) {
            $melhorCotacao = $item->cotacoes->sortBy('preco')->first();
            if ($melhorCotacao) {
                $melhoresCotas[] = [
                    'item' => $item,
                    'fornecedor' => $melhorCotacao->fornecedor,
                    'preco' => $melhorCotacao->preco,
                ];
            }
        }

        return view('dashboard.index', compact('melhoresCotas'));
    }
}
