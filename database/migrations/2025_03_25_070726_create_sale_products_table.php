<?php
// database/migrations/2025_03_25_000001_create_sale_products_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleProductsTable extends Migration
{
    public function up()
    {
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('quantity', 50, 10)->default(0.00);
            $table->decimal('price', 50, 10)->default(0.00);
            $table->string('discount_type')->nullable();
            $table->decimal('discount', 50, 10)->default(0.00);
            $table->decimal('discount_amount', 50, 10)->default(0.00);
            $table->decimal('total_amount', 50, 10)->default(0.00);
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
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
        Schema::dropIfExists('sale_products');
    }
}
