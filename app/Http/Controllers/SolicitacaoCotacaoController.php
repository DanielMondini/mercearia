<?php

namespace App\Http\Controllers;

use App\Models\SolicitacaoCotacao;
use App\Models\Item;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SolicitacaoCotacaoController extends Controller
{
    // Lista as solicitações de cotação
    public function index()
    {
        $solicitacoes = SolicitacaoCotacao::all();
        return view('solicitacoes.index', compact('solicitacoes'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        $itens = Item::all();
        $fornecedores = Fornecedor::all();
        return view('solicitacoes.create', compact('itens', 'fornecedores'));
    }

    // Salva uma nova solicitação de cotação
    public function store(Request $request)
    {

        // Validação dos dados
        $request->validate([
            'nome' => 'required',
            'itens' => 'required|array|min:1',
            'itens.*.nome' => 'required|string',
            'itens.*.unidade_medida' => 'required|string',
            'itens.*.quantidade' => 'required|integer|min:1',
            'fornecedores' => 'required|array|min:1',
            'fornecedores.*.nome' => 'required|string',
        ]);

        // Criação da solicitação de cotação
        $solicitacao = SolicitacaoCotacao::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'data_envio' => now(),
            'itens' => $request->itens,
            'fornecedores' => $request->fornecedores,
        ]);

        // Gerar links de acesso para os fornecedores desta solicitação
        foreach ($solicitacao->fornecedores as $fornecedor) {
            $token = Str::random(32);
            $solicitacao->accessLinks()->create([
                'fornecedor_nome' => $fornecedor['nome'],
                'token' => $token,
            ]);
        }

        return redirect()->route('solicitacoes.show', $solicitacao->id)
            ->with('success', 'Solicitação de cotação criada com sucesso!');
    }

    // Exibe detalhes da solicitação
    public function show(SolicitacaoCotacao $solicitacao)
    {
        // Segunda definição do método show()
        $solicitacao->load('accessLinks');
        return view('solicitacoes.show', compact('solicitacao'));
    }


    // Exibe a dashboard para uma solicitação específica
    public function dashboard(SolicitacaoCotacao $solicitacao)
    {
        $itens = $solicitacao->itens;
        $accessLinks = $solicitacao->accessLinks()->whereNotNull('cotacoes')->get();

        $melhoresCotas = [];
        $itensGanhadoresPorFornecedor = [];
        $precosPorFornecedor = [];

        foreach ($itens as $index => $item) {
            $melhorCotacao = null;
            foreach ($accessLinks as $accessLink) {
                $cotacao = $accessLink->cotacoes[$index];

                // Garantir que 'total' esteja definido
                if (!isset($cotacao['total'])) {
                    $cotacao['total'] = $cotacao['preco'] * $item['quantidade'];
                }

                $fornecedor = $accessLink->fornecedor_nome;

                // Armazenar o preço oferecido pelo fornecedor para este item
                if (!isset($precosPorFornecedor[$fornecedor])) {
                    $precosPorFornecedor[$fornecedor] = [];
                }
                $precosPorFornecedor[$fornecedor][] = [
                    'item' => $item['nome'],
                    'quantidade' => $item['quantidade'],
                    'unidade_medida' => $item['unidade_medida'],
                    'preco' => $cotacao['preco'],
                    'total' => $cotacao['total'],
                    'observacao' => $cotacao['observacao'] ?? null,
                ];

                // Determinar a melhor cotação para o item
                if (!$melhorCotacao || $cotacao['preco'] < $melhorCotacao['preco']) {
                    $melhorCotacao = [
                        'item' => $item['nome'],
                        'quantidade' => $item['quantidade'],
                        'unidade_medida' => $item['unidade_medida'],
                        'fornecedor' => $fornecedor,
                        'preco' => $cotacao['preco'],
                        'total' => $cotacao['total'],
                        'observacao' => $cotacao['observacao'] ?? null,
                    ];
                }
            }
            if ($melhorCotacao) {
                $melhoresCotas[] = $melhorCotacao;

                // Adicionar o item ao fornecedor que ganhou
                if (!isset($itensGanhadoresPorFornecedor[$melhorCotacao['fornecedor']])) {
                    $itensGanhadoresPorFornecedor[$melhorCotacao['fornecedor']] = [];
                }
                $itensGanhadoresPorFornecedor[$melhorCotacao['fornecedor']][] = $melhorCotacao;
            }
        }

// Obter todas as cotações atualizadas
        $precosPorFornecedor = [];
        foreach ($accessLinks as $accessLink) {
            $fornecedor = $accessLink->fornecedor_nome;
            $cotacoes = $accessLink->cotacoes ?? [];

            foreach ($cotacoes as $cotacao) {
                if (!isset($cotacao['total'])) {
                    $cotacao['total'] = $cotacao['preco'] * $cotacao['quantidade'];
                }

                // Garantir que 'item' seja uma string
                if (is_array($cotacao['item'])) {
                    $cotacao['item'] = $cotacao['item']['nome'] ?? 'Item Desconhecido';
                }

                $precosPorFornecedor[$fornecedor][] = $cotacao;
            }
        }

        return view('solicitacoes.dashboard', compact('solicitacao', 'melhoresCotas', 'itensGanhadoresPorFornecedor', 'precosPorFornecedor'));  }
    public function adicionarItem(Request $request, SolicitacaoCotacao $solicitacao)
    {
        // Validar os dados do formulário
        $request->validate([
            'fornecedor_nome' => 'required|string',
            'item.nome' => 'required|string',
            'item.quantidade' => 'required|numeric|min:0',
            'item.unidade_medida' => 'required|string',
            'item.preco' => 'required|numeric|min:0',
            'item.observacao' => 'nullable|string',
        ]);

        $fornecedorNome = $request->input('fornecedor_nome');
        $itemData = $request->input('item');

        // Encontrar o AccessLink do fornecedor
        $accessLink = $solicitacao->accessLinks()->where('fornecedor_nome', $fornecedorNome)->first();

        if (!$accessLink) {
            return redirect()->back()->with('error', 'Fornecedor não encontrado.');
        }

        // Adicionar o item à cotação do fornecedor
        $cotacoes = $accessLink->cotacoes ?? [];

        $novoItem = [
            'item' => $itemData['nome'],
            'unidade_medida' => $itemData['unidade_medida'],
            'preco' => $itemData['preco'],
            'quantidade' => $itemData['quantidade'],
            'total' => $itemData['preco'] * $itemData['quantidade'],
            'observacao' => $itemData['observacao'] ?? null,
        ];


        $cotacoes[] = $novoItem;

        // Atualizar a cotação do fornecedor
        $accessLink->cotacoes = $cotacoes;
        $accessLink->save();

        // Redirecionar de volta ao dashboard com mensagem de sucesso
        return redirect()->route('solicitacoes.dashboard', $solicitacao->id)->with('success', 'Item adicionado com sucesso à cotação do fornecedor.');
    }



    public function adicionarFornecedores(Request $request, SolicitacaoCotacao $solicitacao)
    {
        // Validar os novos fornecedores
        $request->validate([
            'fornecedores' => 'required|array|min:1',
            'fornecedores.*.nome' => 'required|string',
        ]);

        // Adicionar os novos fornecedores à solicitação
        $novosFornecedores = $request->fornecedores;
        $solicitacao->fornecedores = array_merge($solicitacao->fornecedores, $novosFornecedores);
        $solicitacao->save();

        // Gerar links de acesso para os novos fornecedores
        foreach ($novosFornecedores as $fornecedor) {
            $token = Str::random(32);
            $solicitacao->accessLinks()->create([
                'fornecedor_nome' => $fornecedor['nome'],
                'token' => $token,
            ]);
        }

        return redirect()->route('solicitacoes.show', $solicitacao->id)
            ->with('success', 'Novos fornecedores adicionados com sucesso!');
    }

    public function destroy($id)
    {
        $solicitacao = SolicitacaoCotacao::findOrFail($id);
        $solicitacao->delete();

        return redirect()->route('solicitacoes.index')->with('success', 'Solicitação deletada com sucesso.');
    }
}
