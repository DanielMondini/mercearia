@extends('layouts.app')

@php
    $hideHeader = true;
@endphp

@section('content')
    <div class="bg-gray-100 min-h-screen p-8">
        <div class="mx-auto max-w-7xl">
            <!-- Título da Página -->
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">{{ $solicitacao->nome }} - Cotação de Preços - {{ $fornecedorNome }}</h1>

            <!-- Exibir mensagens de sucesso -->
{{--            @if(session('success'))--}}
{{--                <div class="mb-4 rounded-md bg-green-50 p-4">--}}
{{--                    <div class="flex">--}}
{{--                        <div class="flex-shrink-0">--}}
{{--                            <!-- Ícone de sucesso -->--}}
{{--                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />--}}
{{--                            </svg>--}}
{{--                        </div>--}}
{{--                        <div class="ml-3">--}}
{{--                            <p class="text-sm font-medium text-green-800">--}}
{{--                                {{ session('success') }}--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}

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

                <!-- Layout para telas médias e grandes -->
                <div class="hidden sm:block" data-layout="desktop">
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
                                    $index = $loop->index;
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
                </div>

                <!-- Layout para dispositivos móveis -->
                <div class="sm:hidden" data-layout="mobile">
                    @foreach($itens as $item)
                        @php
                            $index = $loop->index;
                            $preco = isset($cotacoesExistentes[$index]['preco']) ? $cotacoesExistentes[$index]['preco'] : '';
                            $total = isset($cotacoesExistentes[$index]['total']) ? $cotacoesExistentes[$index]['total'] : '';
                            $observacao = isset($cotacoesExistentes[$index]['observacao']) ? $cotacoesExistentes[$index]['observacao'] : '';
                        @endphp
                        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                            <div class="mb-2">
                                <strong>Item:</strong> {{ $item['nome'] }}
                            </div>
                            <div class="mb-2">
                                <strong>Unidade de Medida:</strong> {{ $item['unidade_medida'] }}
                            </div>
                            <div class="mb-2">
                                <strong>Quantidade:</strong> {{ $item['quantidade'] }}
                            </div>
                            <div class="mb-2">
                                <label for="mobile-preco-{{ $index }}" class="block text-sm font-medium text-gray-700">Preço (R$)</label>
                                <input type="number" step="0.01" name="precos[{{ $index }}]" id="mobile-preco-{{ $index }}" oninput="calcularTotal({{ $index }}, {{ $item['quantidade'] }})" value="{{ old('precos.' . $index, $preco) }}" class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="mb-2">
                                <label for="mobile-total-{{ $index }}" class="block text-sm font-medium text-gray-700">Total (R$)</label>
                                <input type="text" id="mobile-total-{{ $index }}" readonly value="{{ is_numeric($total) ? number_format($total, 2, '.', '') : '' }}" class="mt-1 w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm p-2">
                            </div>
                            <div class="mb-2">
                                <label for="mobile-observacao-{{ $index }}" class="block text-sm font-medium text-gray-700">Observação</label>
                                <input type="text" name="observacoes[{{ $index }}]" id="mobile-observacao-{{ $index }}" placeholder="Observação" value="{{ old('observacoes.' . $index, $observacao) }}" class="mt-1 w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    @endforeach
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
        document.addEventListener('DOMContentLoaded', function() {
            ajustarCampos();
            // Calcular os totais iniciais
            @foreach($itens as $item)
            calcularTotal({{ $loop->index }}, {{ $item['quantidade'] }});
            @endforeach
        });

        window.addEventListener('resize', function() {
            ajustarCampos();
        });

        function ajustarCampos() {
            let isMobile = window.innerWidth < 640; // 640px é o ponto de corte do Tailwind para 'sm'

            // Seleciona os layouts
            let desktopLayout = document.querySelector('[data-layout="desktop"]');
            let mobileLayout = document.querySelector('[data-layout="mobile"]');

            if (isMobile) {
                // Desabilita os inputs do desktop
                desktopLayout.querySelectorAll('input, select, textarea').forEach(function(el) {
                    el.disabled = true;
                });
                // Habilita os inputs do mobile
                mobileLayout.querySelectorAll('input, select, textarea').forEach(function(el) {
                    el.disabled = false;
                });
            } else {
                // Habilita os inputs do desktop
                desktopLayout.querySelectorAll('input, select, textarea').forEach(function(el) {
                    el.disabled = false;
                });
                // Desabilita os inputs do mobile
                mobileLayout.querySelectorAll('input, select, textarea').forEach(function(el) {
                    el.disabled = true;
                });
            }
        }

        function calcularTotal(index, quantidade) {
            let precoInputDesktop = document.getElementById('preco-' + index);
            let totalInputDesktop = document.getElementById('total-' + index);
            let precoInputMobile = document.getElementById('mobile-preco-' + index);
            let totalInputMobile = document.getElementById('mobile-total-' + index);

            let preco = 0;

            // Verifica qual input de preço está habilitado
            if (precoInputDesktop && !precoInputDesktop.disabled) {
                preco = parseFloat(precoInputDesktop.value) || 0;
            } else if (precoInputMobile && !precoInputMobile.disabled) {
                preco = parseFloat(precoInputMobile.value) || 0;
            }

            let total = preco * quantidade;

            // Atualiza o campo total habilitado
            if (totalInputDesktop && !totalInputDesktop.disabled) {
                totalInputDesktop.value = (preco > 0) ? total.toFixed(2) : '';
            }
            if (totalInputMobile && !totalInputMobile.disabled) {
                totalInputMobile.value = (preco > 0) ? total.toFixed(2) : '';
            }
        }
    </script>
@endsection
