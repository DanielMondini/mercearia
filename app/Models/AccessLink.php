<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'fornecedor_nome',
        'token',
        'cotacoes',
        'solicitacao_cotacao_id',
    ];

    protected $casts = [
        'cotacoes' => 'array',
    ];

    public function solicitacaoCotacao()
    {
        return $this->belongsTo(SolicitacaoCotacao::class);
    }
}
