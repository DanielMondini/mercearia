@extends('layouts.app')

@section('content')
    <h1>{{ isset($fornecedor) ? 'Editar Fornecedor' : 'Adicionar Fornecedor' }}</h1>

    <form action="{{ isset($fornecedor) ? route('fornecedores.update', $fornecedor->id) : route('fornecedores.store') }}" method="POST">
        @csrf
        @if(isset($fornecedor))
            @method('PUT')
        @endif
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="{{ old('nome', $fornecedor->nome ?? '') }}" required>
        </div>
        <button type="submit">{{ isset($fornecedor) ? 'Atualizar' : 'Salvar' }}</button>
    </form>
@endsection
