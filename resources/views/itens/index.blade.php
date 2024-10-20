@extends('layouts.app')

@section('content')
    <h1>Lista de Itens</h1>

    <a href="{{ route('itens.create') }}">Adicionar Item</a>

    <table>
        <thead>
        <tr>
            <th>Nome</th>
            <th>Unidade de Medida</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($itens as $item)
            <tr>
                <td>{{ $item->nome }}</td>
                <td>{{ $item->unidade_medida }}</td>
                <td>{{ $item->quantidade }}</td>
                <td>
                    <a href="{{ route('itens.edit', $item->id) }}">Editar</a>
                    <form action="{{ route('itens.destroy', $item->id) }}" method="POST" style="display:inline;">
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
