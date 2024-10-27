<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('access_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitacao_cotacao_id')->constrained('solicitacao_cotacoes')->onDelete('cascade');
            $table->foreignId('fornecedor_id')->constrained('fornecedores')->onDelete('cascade');
            $table->string('token')->unique();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_links');
    }
};
