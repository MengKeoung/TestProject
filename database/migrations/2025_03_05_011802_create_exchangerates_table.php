<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchangerates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('from_currency'); // Add column first
            $table->unsignedBigInteger('to_currency');   // Add column first
            $table->foreign('from_currency')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('to_currency')->references('id')->on('currencies')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchangerates');
    }
}
