<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'solicitacao_cotacao_id',
        'item_id',
        'preco',
        'observacao',
        // Outros campos...
    ];

    public function solicitacaoCotacao()
    {
        return $this->belongsTo(SolicitacaoCotacao::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
