<?php

namespace App\Http\Controllers;

use App\Models\AccessLink;
use Illuminate\Http\Request;

class CotacaoController extends Controller
{
    // Exibe o formulário de cotação para o fornecedor
    public function formCotacao($token)
    {
        $accessLink = AccessLink::where('token', $token)->firstOrFail();
        $solicitacao = $accessLink->solicitacaoCotacao;
        $fornecedorNome = $accessLink->fornecedor_nome;
        $itens = $solicitacao->itens;

        // Obter as cotações existentes do fornecedor, se houver
        $cotacoesExistentes = $accessLink->cotacoes;

        return view('cotacao.form', compact('fornecedorNome', 'itens', 'token', 'solicitacao', 'cotacoesExistentes'));
    }

    // Salva a cotação preenchida pelo fornecedor
    public function salvarCotacao(Request $request, $token)
    {
        $accessLink = AccessLink::where('token', $token)->firstOrFail();
        $solicitacao = $accessLink->solicitacaoCotacao;

        $itens = $solicitacao->itens;

        // Validar os preços e observações
        $request->validate([
            'precos' => 'required|array',
            'precos.*' => 'nullable|numeric|min:0', // Preços agora são opcionais
            'observacoes' => 'nullable|array',
            'observacoes.*' => 'nullable|string',
        ]);

        // Atualizar as cotações existentes
        $cotacoes = [];
        foreach ($itens as $index => $item) {
            // Obter o preço e observação do fornecedor, se existirem
            $preco = $request->precos[$index] ?? null; // Permitir null
            $quantidade = $item['quantidade'];
            $total = ($preco !== null) ? $preco * $quantidade : null; // Total apenas se preço for fornecido
            $observacao = $request->observacoes[$index] ?? null;

            $cotacoes[] = [
                'item' => $item['nome'],
                'unidade_medida' => $item['unidade_medida'],
                'preco' => $preco,
                'quantidade' => $quantidade,
                'total' => $total,
                'observacao' => $observacao,
            ];
        }

        // Atualizar as cotações no AccessLink
        $accessLink->cotacoes = $cotacoes;
        $accessLink->save();

        return redirect()->route('cotacao.formCotacao', $token)->with('success', 'Cotação atualizada com sucesso!');
    }
}
