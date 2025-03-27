<?php
// database/migrations/2025_03_25_000002_create_sale_payments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('payment_date')->useCurrent();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('payment_type_id')->constrained('payment_types')->onDelete('cascade');
            $table->decimal('total_amount', 50, 10)->default(0.00);
            $table->decimal('total_paid', 50, 10)->default(0.00);
            $table->decimal('balance', 50, 10)->default(0.00);
            $table->decimal('change_amount', 50, 10)->default(0.00);
            $table->string('note')->nullable();
            $table->foreignId('creation_by')->nullable()->constrained('users')->onDelete('set null');
            // $table->timestamp('creation')->useCurrent();
            $table->foreignId('modified_by')->nullable()->constrained('users')->onDelete('set null');
            // $table->timestamp('modified')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('is_deleted')->default(false);
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_payments');
    }
}
