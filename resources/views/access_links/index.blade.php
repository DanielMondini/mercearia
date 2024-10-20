@extends('layouts.app')

@section('content')
    <h1>Links de Acesso para Fornecedores</h1>

    <a href="{{ route('gerar.links') }}">Gerar Novos Links</a>

    <table>
        <thead>
        <tr>
            <th>Fornecedor</th>
            <th>Link de Acesso</th>
        </tr>
        </thead>
        <tbody>
        @foreach($accessLinks as $link)
            <tr>
                <td>{{ $link->fornecedor->nome }}</td>
                <td>
                    <a href="{{ url('/cotacao/' . $link->token) }}" target="_blank">{{ url('/cotacao/' . $link->token) }}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
