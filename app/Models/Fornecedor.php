<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

    protected $fillable = ['nome'];

    public function solicitacoesCotacao()
    {
        return $this->belongsToMany(SolicitacaoCotacao::class, 'solicitacao_cotacao_fornecedor')->withTimestamps();
    }
}
