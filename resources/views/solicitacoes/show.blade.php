@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8">
            <!-- Cabeçalho da Página -->
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $solicitacao->nome }}</h1>
                <p class="mt-2 text-md text-gray-600">{{ $solicitacao->descricao }}</p>
            </div>

            <!-- Itens -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Itens</h3>
                <ul class="list-disc list-inside space-y-2">
                    @if(!empty($solicitacao->itens))
                        @foreach($solicitacao->itens as $item)
                            <li class="text-gray-700">
                                <span class="font-medium">{{ $item['nome'] }}</span> - Quantidade: {{ $item['quantidade'] }} - Unidade: {{ $item['unidade_medida'] }}
                            </li>
                        @endforeach
                    @else
                        <li class="text-gray-500">Nenhum item encontrado.</li>
                    @endif
                </ul>
            </div>

            <!-- Fornecedores -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Fornecedores</h3>
                <ul class="list-disc list-inside space-y-2">
                    @if(!empty($solicitacao->fornecedores))
                        @foreach($solicitacao->fornecedores as $index => $fornecedor)
                            <li class="text-gray-700">
                                <span class="font-medium">{{ $fornecedor['nome'] }}</span>
                                @php
                                    $link = $solicitacao->accessLinks[$index] ?? null;
                                @endphp
                                @if($link)
                                    - Link de Acesso: <a href="{{ url('/cotacao/' . $link->token) }}" target="_blank" class="text-indigo-600 hover:underline">{{ url('/cotacao/' . $link->token) }}</a>
                                @else
                                    - Link não disponível
                                @endif
                            </li>
                        @endforeach
                    @else
                        <li class="text-gray-500">Nenhum fornecedor encontrado.</li>
                    @endif
                </ul>
            </div>

            <!-- Formulário para adicionar novos fornecedores -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Adicionar Novos Fornecedores</h2>

                <!-- Exibir mensagens de sucesso ou erro -->
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

                <form action="{{ route('solicitacoes.adicionarFornecedores', $solicitacao->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div id="fornecedores-container" class="space-y-4">
                        <div class="fornecedor flex items-center space-x-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Nome do Fornecedor</label>
                                <input type="text" name="fornecedores[0][nome]" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <button type="button" onclick="removerFornecedor(this)" class="text-red-600 hover:text-red-800 text-xl">&times;</button>
                        </div>
                    </div>
                    <button type="button" onclick="adicionarFornecedor()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Adicionar Outro Fornecedor
                    </button>
                    <button type="submit" class="mt-4 w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Salvar Fornecedores
                    </button>
                </form>
            </div>

            <!-- Link para o Dashboard -->
            <div class="text-center">
                <a href="{{ route('solicitacoes.dashboard', ['solicitacao' => $solicitacao->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Ver Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        let fornecedorIndex = 1;

        function adicionarFornecedor() {
            const container = document.getElementById('fornecedores-container');
            const fornecedorDiv = document.createElement('div');
            fornecedorDiv.classList.add('fornecedor', 'flex', 'items-center', 'space-x-4');

            fornecedorDiv.innerHTML = `
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Nome do Fornecedor</label>
                    <input type="text" name="fornecedores[${fornecedorIndex}][nome]" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="button" onclick="removerFornecedor(this)" class="text-red-600 hover:text-red-800 text-xl">&times;</button>
            `;

            container.appendChild(fornecedorDiv);
            fornecedorIndex++;
        }

        function removerFornecedor(button) {
            const fornecedorDiv = button.parentElement;
            fornecedorDiv.remove();
        }
    </script>
@endsection
