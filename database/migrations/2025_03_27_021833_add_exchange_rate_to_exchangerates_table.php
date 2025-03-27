<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExchangeRateToExchangeratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exchangerates', function (Blueprint $table) {
            $table->decimal('exchange_rate', 15, 8); // Add the exchange_rate field
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exchangerates', function (Blueprint $table) {
            $table->dropColumn('exchange_rate'); // Remove the exchange_rate field
        });
    }
}
