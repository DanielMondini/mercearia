<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['nome', 'unidade_medida'];

    public function cotacoes()
    {
        return $this->hasMany(Cotacao::class);
    }

    public function solicitacoesCotacao()
    {
        return $this->belongsToMany(SolicitacaoCotacao::class, 'solicitacao_cotacao_item')->withPivot('quantidade')->withTimestamps();
    }
}
