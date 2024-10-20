<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\AccessLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AccessLinkController extends Controller
{
    // Gera os links para todos os fornecedores
    public function gerarLinks()
    {
        $fornecedores = Fornecedor::all();

        foreach ($fornecedores as $fornecedor) {
            $token = Str::random(32);
            AccessLink::updateOrCreate(
                ['fornecedor_id' => $fornecedor->id],
                ['token' => $token]
            );
        }

        return redirect()->route('links.index')->with('success', 'Links gerados com sucesso!');
    }

    // Lista os links de acesso
    public function listarLinks()
    {
        $accessLinks = AccessLink::with('fornecedor')->get();

        return view('access_links.index', compact('accessLinks'));
    }
}
