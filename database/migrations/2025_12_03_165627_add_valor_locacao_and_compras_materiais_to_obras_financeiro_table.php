<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValorLocacaoAndComprasMateriaisToObrasFinanceiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obras_financeiro', function (Blueprint $table) {
            $table->decimal('valor_locacao', 15, 2)->default(0)->after('saldo');
            $table->decimal('valor_compras_materiais', 15, 2)->default(0)->after('valor_locacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obras_financeiro', function (Blueprint $table) {
            $table->dropColumn(['valor_locacao', 'valor_compras_materiais']);
        });
    }
}
