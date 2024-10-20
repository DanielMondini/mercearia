<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFornecedorIdFromAccessLinksTable extends Migration
{
    public function up()
    {
        Schema::table('access_links', function (Blueprint $table) {
            // Se houver chave estrangeira, remova primeiro
            $table->dropForeign(['fornecedor_id']);
            $table->dropColumn('fornecedor_id');
        });
    }

    public function down()
    {
        Schema::table('access_links', function (Blueprint $table) {
            $table->foreignId('fornecedor_id')->constrained('fornecedores')->onDelete('cascade');
        });
    }
}
