<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacaoCotacoesTableV3 extends Migration

{
    public function up()
    {
        Schema::create('solicitacao_cotacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->date('data_envio')->nullable();
            $table->json('itens'); // Armazenar itens como JSON
            $table->json('fornecedores'); // Armazenar fornecedores como JSON
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitacao_cotacoes');
    }
}