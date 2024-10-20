<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('access_links', function (Blueprint $table) {
            $table->string('fornecedor_nome')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('access_links', function (Blueprint $table) {
            $table->dropColumn('fornecedor_nome');
        });
    }
};
