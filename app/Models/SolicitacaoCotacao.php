<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoCotacao extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'data_envio',
        'itens',
        'fornecedores',
    ];

    protected $casts = [
        'data_envio' => 'datetime',
        'itens' => 'array',
        'fornecedores' => 'array',
    ];



    public function itens()
    {
        return $this->belongsToMany(Item::class, 'solicitacao_cotacao_item')->withPivot('quantidade');
    }

    public function cotacoes()
    {
        return $this->hasMany(Cotacao::class);
    }

    public function fornecedores()
    {
        return $this->belongsToMany(Fornecedor::class, 'solicitacao_cotacao_fornecedor');
    }

    public function accessLinks()
    {
        return $this->hasMany(AccessLink::class);
    }


}
