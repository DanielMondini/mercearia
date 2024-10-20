@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl w-full space-y-8">
            <!-- Cabeçalho da Página -->
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Criar Nova Solicitação de Cotação</h1>
            </div>

            <!-- Exibir mensagens de erro -->
            @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Ícone de erro -->
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Ocorreu um erro ao processar sua solicitação:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $erro)
                                    <li>{{ $erro }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulário -->
            <form class="mt-8 space-y-6 bg-white p-8 rounded-lg shadow-md" action="{{ route('solicitacoes.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <!-- Nome da Solicitação -->
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700">Nome da Solicitação</label>
                        <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <textarea name="descricao" id="descricao" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('descricao') }}</textarea>
                    </div>

                    <hr class="border-gray-300">

                    <!-- Seção: Adicionar Itens -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Adicionar Itens</h3>
                        <div id="itens-container" class="space-y-4 mt-4">
                            <div class="item p-4 border border-gray-200 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nome do Item</label>
                                        <input type="text" name="itens[0][nome]" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Unidade de Medida</label>
                                        <input type="text" name="itens[0][unidade_medida]" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Quantidade</label>
                                        <input type="number" name="itens[0][quantidade]" min="1" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                </div>
                                <!-- Botão de Remover Item (opcional) -->
                                <div class="mt-2 text-right">
                                    <button type="button" onclick="removerItem(this)" class="text-red-600 hover:text-red-800 text-sm">Remover</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="adicionarItem()" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Adicionar Mais Item
                        </button>
                    </div>

                    <hr class="border-gray-300">

                    <!-- Seção: Adicionar Fornecedores -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Adicionar Fornecedores</h3>
                        <div id="fornecedores-container" class="space-y-4 mt-4">
                            <div class="fornecedor p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700">Nome do Fornecedor</label>
                                        <input type="text" name="fornecedores[0][nome]" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                </div>
                                <!-- Botão de Remover Fornecedor (opcional) -->
                                <div class="mt-2 text-right">
                                    <button type="button" onclick="removerFornecedor(this)" class="text-red-600 hover:text-red-800 text-sm">Remover</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="adicionarFornecedor()" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Adicionar Mais Fornecedor
                        </button>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Criar Solicitação
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let itemIndex = 1;
        function adicionarItem() {
            let container = document.getElementById('itens-container');
            let itemDiv = document.createElement('div');
            itemDiv.classList.add('item', 'p-4', 'border', 'border-gray-200', 'rounded-lg', 'space-y-4');

            itemDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome do Item</label>
                        <input type="text" name="itens[${itemIndex}][nome]" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Unidade de Medida</label>
                        <input type="text" name="itens[${itemIndex}][unidade_medida]" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantidade</label>
                        <input type="number" name="itens[${itemIndex}][quantidade]" min="1" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div class="mt-2 text-right">
                    <button type="button" onclick="removerItem(this)" class="text-red-600 hover:text-red-800 text-sm">Remover</button>
                </div>
            `;
            container.appendChild(itemDiv);
            itemIndex++;
        }

        let fornecedorIndex = 1;
        function adicionarFornecedor() {
            let container = document.getElementById('fornecedores-container');
            let fornecedorDiv = document.createElement('div');
            fornecedorDiv.classList.add('fornecedor', 'p-4', 'border', 'border-gray-200', 'rounded-lg', 'space-y-4');

            fornecedorDiv.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700">Nome do Fornecedor</label>
                        <input type="text" name="fornecedores[${fornecedorIndex}][nome]" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div class="mt-2 text-right">
                    <button type="button" onclick="removerFornecedor(this)" class="text-red-600 hover:text-red-800 text-sm">Remover</button>
                </div>
            `;
            container.appendChild(fornecedorDiv);
            fornecedorIndex++;
        }

        function removerItem(button) {
            let itemDiv = button.parentElement.parentElement;
            itemDiv.remove();
        }

        function removerFornecedor(button) {
            let fornecedorDiv = button.parentElement.parentElement;
            fornecedorDiv.remove();
        }
    </script>
@endsection
