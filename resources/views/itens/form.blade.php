@extends('layouts.app')

@section('content')
    <h1>{{ isset($item) ? 'Editar Item' : 'Adicionar Item' }}</h1>

    <form action="{{ isset($item) ? route('itens.update', $item->id) : route('itens.store') }}" method="POST">
        @csrf
        @if(isset($item))
            @method('PUT')
        @endif
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="{{ old('nome', $item->nome ?? '') }}" required>
        </div>
        <div>
            <label for="unidade_medida">Unidade de Medida:</label>
            <input type="text" name="unidade_medida" value="{{ old('unidade_medida', $item->unidade_medida ?? '') }}" required>
        </div>
        <div>
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" value="{{ old('quantidade', $item->quantidade ?? '') }}" required>
        </div>
        <button type="submit">{{ isset($item) ? 'Atualizar' : 'Salvar' }}</button>
    </form>
@endsection
