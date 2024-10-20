@extends('layouts.app')

@section('content')
    <h1>Dashboard de Cotações</h1>

    <table>
        <thead>
        <tr>
            <th>Item</th>
            <th>Fornecedor</th>
            <th>Preço (R$)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($melhoresCotas as $cotacao)
            <tr>
                <td>{{ $cotacao['item']->nome }}</td>
                <td>{{ $cotacao['fornecedor']->nome }}</td>
                <td>{{ number_format($cotacao['preco'], 2, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
