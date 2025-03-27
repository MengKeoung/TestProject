<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_code');
            $table->timestamp('sale_date')->useCurrent();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->onDelete('cascade');
            $table->foreignId('status_id')->nullable()->constrained('sale_statuses')->onDelete('set null');
            $table->string('vattin_number')->nullable();
            $table->decimal('total_quantity', 50, 10)->default(0.00);
            $table->decimal('sub_total', 50, 10)->default(0.00);
            // $table->string('discount_type')->nullable();
            // $table->decimal('discount', 50, 10)->default(0.00);
            $table->decimal('sale_discount', 50, 10)->default(0.00);
            // $table->decimal('product_discount', 50, 10)->default(0.00);
            // $table->decimal('total_discount', 50, 10)->default(0.00);
            $table->boolean('is_include_vat')->default(false);
            $table->boolean('is_include_sc')->default(false);
            $table->decimal('service_charge', 50, 10)->default(0.00);
            $table->decimal('vat', 50, 10)->default(0.00);
            $table->decimal('grand_total', 50, 10)->default(0.00);
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
        Schema::dropIfExists('sales');
    }
}

