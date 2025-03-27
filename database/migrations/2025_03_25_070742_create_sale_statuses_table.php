<?php
// database/migrations/2025_03_25_000003_create_sale_statuses_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('sale_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->foreignId('creation_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('creation')->useCurrent();
            $table->foreignId('modified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('modified')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('is_deleted')->default(false);
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_statuses');
    }
}
