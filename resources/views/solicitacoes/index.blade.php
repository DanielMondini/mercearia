@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <!-- Cabeçalho da Página -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Solicitações de Cotação</h1>
            <a href="{{ route('solicitacoes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Criar Nova Solicitação
            </a>
        </div>

        <!-- Tabela de Solicitações -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nome
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Data de Envio
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ações
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($solicitacoes as $solicitacao)
                    <tr class="hover:bg-gray-100 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $solicitacao->nome }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $solicitacao->data_envio ? $solicitacao->data_envio->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 space-x-4">
                            <a href="{{ route('solicitacoes.show', $solicitacao->id) }}" class="text-indigo-600 hover:text-indigo-900">Detalhes</a>
                            <a href="{{ route('solicitacoes.dashboard', $solicitacao->id) }}" class="text-indigo-600 hover:text-indigo-900">Dashboard</a>
                            <form action="{{ route('solicitacoes.destroy', $solicitacao->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta solicitação?')" class="text-red-600 hover:text-red-900">Excluir</button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            Nenhuma solicitação encontrada.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>


    </div>
@endsection
