@extends('layouts.app')

@section('content')
    <h1>Lista de Fornecedores</h1>

    <a href="{{ route('fornecedores.create') }}">Adicionar Fornecedor</a>

    <table>
        <thead>
        <tr>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($fornecedores as $fornecedor)
            <tr>
                <td>{{ $fornecedor->nome }}</td>
                <td>
                    <a href="{{ route('fornecedores.edit', $fornecedor->id) }}">Editar</a>
                    <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
