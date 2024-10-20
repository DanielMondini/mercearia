@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen p-8">
        <div class="mx-auto max-w-7xl">
            <!-- Título da Página -->
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">{{ $solicitacao->nome }} - Cotação de Preços - {{ $fornecedorNome }}</h1>

            <!-- Exibir mensagens de sucesso -->
            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Ícone de sucesso -->
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Exibir erros de validação -->
            @if($errors->any())
                <div class="mb-4 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Ícone de erro -->
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                <strong>Ocorreu um erro:</strong>
                            </p>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulário de Cotação -->
            <form action="{{ route('cotacao.salvarCotacao', $token) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
                @csrf
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-700 sm:pl-0">Item</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Unidade de Medida</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Quantidade</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Preço (R$)</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Total (R$)</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Observação</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach($itens as $item)
                            @php
                                $index = $loop->index; // Índice sequencial começando em 0
                                // Pré-preencher os valores se houver cotações existentes
                                $preco = isset($cotacoesExistentes[$index]['preco']) ? $cotacoesExistentes[$index]['preco'] : '';
                                $total = isset($cotacoesExistentes[$index]['total']) ? $cotacoesExistentes[$index]['total'] : '';
                                $observacao = isset($cotacoesExistentes[$index]['observacao']) ? $cotacoesExistentes[$index]['observacao'] : '';
                            @endphp
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{ $item['nome'] }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $item['unidade_medida'] }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $item['quantidade'] }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                    <input type="number" step="0.01" name="precos[{{ $index }}]" id="preco-{{ $index }}" oninput="calcularTotal({{ $index }}, {{ $item['quantidade'] }})" value="{{ old('precos.' . $index, $preco) }}" class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                    <input type="text" id="total-{{ $index }}" readonly value="{{ is_numeric($total) ? number_format($total, 2, '.', '') : '' }}" class="w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm p-2">
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                    <input type="text" name="observacoes[{{ $index }}]" placeholder="Observação" value="{{ old('observacoes.' . $index, $observacao) }}" class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Enviar Cotação
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calcularTotal(index, quantidade) {
            let precoInput = document.getElementById('preco-' + index);
            let totalInput = document.getElementById('total-' + index);

            if (!precoInput || !totalInput) {
                console.error(`Element not found for index: ${index}`);
                return;
            }

            let preco = parseFloat(precoInput.value) || 0;
            let total = preco * quantidade;

            console.log(`Index: ${index}, Quantidade: ${quantidade}, Preço: ${preco}, Total: ${total}`);

            // Se o preço for zero ou vazio, deixe o total vazio
            totalInput.value = (precoInput.value && preco > 0) ? total.toFixed(2) : '';
        }

        // Calcular os totais iniciais ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($itens as $item)
            calcularTotal({{ $loop->index }}, {{ $item['quantidade'] }});
            @endforeach
        });
    </script>
@endsection
