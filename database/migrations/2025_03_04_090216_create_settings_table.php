<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('english_name');
            $table->string('khmer_name');
            $table->string('phone');
            $table->string('gmail');
            $table->string('vattin_number');
            $table->decimal('tax', 10, 2); // Adjust the size of the decimal field as needed
            $table->string('copyright');
            $table->text('address');
            $table->string('logo')->nullable(); // Adding the logo field to store image path
            $table->timestamps(); // created_at, updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
