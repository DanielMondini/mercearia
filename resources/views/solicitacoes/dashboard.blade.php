@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen p-8">
        <div class="mx-auto max-w-7xl">
            <!-- Título da Dashboard -->
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Dashboard - {{ $solicitacao->nome }}</h1>

            <!-- Seção: Melhores Cotações por Item -->
            <div class="bg-white rounded-lg shadow-md mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800">Melhores Cotações por Item</h3>
                </div>
                <div class="px-4 py-6">
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-700 sm:pl-0">Item</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Quantidade</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Unidade</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Fornecedor</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Preço Unitário (R$)</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Total (R$)</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @php
                                    $totalGeralMelhoresCotas = 0;
                                @endphp
                                @foreach($melhoresCotas as $melhorCotacao)
                                    @php
                                        if ($melhorCotacao['preco'] == 0) {
                                            continue; // Ignora este item e passa para o próximo
                                        }
                                        $subtotal = $melhorCotacao['preco'] * $melhorCotacao['quantidade'];
                                        $totalGeralMelhoresCotas += $subtotal;
                                    @endphp
                                    <tr class="hover:bg-gray-100 transition duration-150">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $melhorCotacao['item'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $melhorCotacao['quantidade'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $melhorCotacao['unidade_medida'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $melhorCotacao['fornecedor'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">R$ {{ number_format($melhorCotacao['preco'], 2, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="5" class="py-4 text-right text-sm font-semibold text-gray-800">Total Geral:</td>
                                    <td class="py-4 text-sm font-semibold text-gray-800">R$ {{ number_format($totalGeralMelhoresCotas, 2, ',', '.') }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seção: Preços Oferecidos por Cada Fornecedor -->
            <div class="bg-white rounded-lg shadow-md mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800">Preços Oferecidos por Cada Fornecedor</h3>
                </div>
                @foreach($precosPorFornecedor as $fornecedor => $precos)
                    <div class="px-4 py-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Fornecedor: {{ $fornecedor }}</h4>
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full">
                                <table class="min-w-full divide-y divide-gray-200 mb-4">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-700 sm:pl-0">Item</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Quantidade</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Unidade</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Preço Oferecido (R$)</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Total (R$)</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Observação</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @php
                                        $totalFornecedor = 0;
                                    @endphp
                                    @foreach($precos as $preco)
                                        @php
                                            $totalFornecedor += $preco['total'];
                                        @endphp
                                        <tr class="hover:bg-gray-100 transition duration-150">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $preco['item'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $preco['quantidade'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $preco['unidade_medida'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">R$ {{ number_format($preco['preco'], 2, ',', '.') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">R$ {{ number_format($preco['total'], 2, ',', '.') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $preco['observacao'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="4" class="py-4 text-right text-sm font-semibold text-gray-800">Total do Fornecedor:</td>
                                        <td class="py-4 text-sm font-semibold text-gray-800">R$ {{ number_format($totalFornecedor, 2, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Seção: Itens Ganhos por Fornecedor -->
            <div class="bg-white rounded-lg shadow-md mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800">Itens Ganhos por Fornecedor</h3>
                </div>
                @foreach($itensGanhadoresPorFornecedor as $fornecedor => $itensGanhados)
                    <div class="px-4 py-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Fornecedor: {{ $fornecedor }}</h4>
                        <div class="overflow-x-auto">
                            <div class="inline-block min-w-full">
                                <table class="min-w-full divide-y divide-gray-200 mb-4">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-700 sm:pl-0">Item</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Quantidade</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Unidade</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Preço Unitário (R$)</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Total (R$)</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-700">Observação</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @php
                                        $totalGanhadoFornecedor = 0;
                                    @endphp
                                    @foreach($itensGanhados as $item)
                                        @php
                                            if ($item['preco'] == 0) {
                                                continue; // Ignora este item e passa para o próximo
                                            }
                                            $totalGanhadoFornecedor += $item['total'];
                                        @endphp
                                        <tr class="hover:bg-gray-100 transition duration-150">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $item['item'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $item['quantidade'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $item['unidade_medida'] }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">R$ {{ number_format($item['total'], 2, ',', '.') }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $item['observacao'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="4" class="py-4 text-right text-sm font-semibold text-gray-800">Total dos Itens Ganhos:</td>
                                        <td class="py-4 text-sm font-semibold text-gray-800">R$ {{ number_format($totalGanhadoFornecedor, 2, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- Botão para adicionar item -->
                        <div class="flex justify-end">
                            <button
                                type="button"
                                class="mt-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                onclick="mostrarFormularioAdicionarItem('{{ addslashes($fornecedor) }}')">
                                Adicionar Item
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Formulário para adicionar item -->
            <div id="form-adicionar-item" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Adicionar Item para o Fornecedor: <span id="nome-fornecedor" class="text-indigo-600"></span></h3>
                    <form action="{{ route('solicitacoes.adicionarItem', $solicitacao->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="fornecedor_nome" id="fornecedor-nome-input">

                        <div class="mb-4">
                            <label for="item-nome" class="block text-sm font-medium text-gray-700">Nome do Item:</label>
                            <input type="text" name="item[nome]" id="item-nome" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="item-quantidade" class="block text-sm font-medium text-gray-700">Quantidade:</label>
                            <input type="number" name="item[quantidade]" id="item-quantidade" required min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="item-unidade" class="block text-sm font-medium text-gray-700">Unidade de Medida:</label>
                            <input type="text" name="item[unidade_medida]" id="item-unidade" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="item-preco" class="block text-sm font-medium text-gray-700">Preço Unitário (R$):</label>
                            <input type="number" step="0.01" name="item[preco]" id="item-preco" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="item-observacao" class="block text-sm font-medium text-gray-700">Observação:</label>
                            <input type="text" name="item[observacao]" id="item-observacao" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Adicionar Item</button>
                            <button type="button" onclick="esconderFormularioAdicionarItem()" class="rounded-md bg-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarFormularioAdicionarItem(fornecedorNome) {
            document.getElementById('form-adicionar-item').classList.remove('hidden');
            document.getElementById('nome-fornecedor').innerText = fornecedorNome;
            document.getElementById('fornecedor-nome-input').value = fornecedorNome;
        }

        function esconderFormularioAdicionarItem() {
            document.getElementById('form-adicionar-item').classList.add('hidden');
            // Limpar os campos do formulário
            document.getElementById('item-nome').value = '';
            document.getElementById('item-quantidade').value = '';
            document.getElementById('item-unidade').value = '';
            document.getElementById('item-preco').value = '';
            document.getElementById('item-observacao').value = '';
        }

        // Fechar o formulário ao clicar fora dele
        window.addEventListener('click', function(event) {
            const form = document.getElementById('form-adicionar-item');
            const formContent = form.querySelector('.bg-white');
            if (event.target === form) {
                esconderFormularioAdicionarItem();
            }
        });
    </script>
@endsection
