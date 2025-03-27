<?php
// app/Models/SaleProduct.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\products;

class SaleProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'product_id', 'quantity', 'price', 'discount_type', 'discount', 'discount_amount', 
        'total_amount', 'sale_id', 'creation_by', 'modified_by', 'is_deleted', 'deleted_by'
    ];

    protected $dates = ['creation', 'modified'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function creationBy()
    {
        return $this->belongsTo(User::class, 'creation_by');
    }

    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
