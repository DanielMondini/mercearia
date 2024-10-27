<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacaoCotacaoFornecedorTable extends Migration
{
    public function up()
    {
        Schema::create('solicitacao_cotacao_fornecedor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitacao_cotacao_id')
                ->constrained('solicitacao_cotacoes') // Nome correto da tabela
                ->onDelete('cascade');
            $table->foreignId('fornecedor_id')->constrained('fornecedores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitacao_cotacao_fornecedor');
    }
}
