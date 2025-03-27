<?php
// app/Models/Sale.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_code', 'customer_id', 'shift_id', 'status_id', 'vattin_number', 'total_quantity',
        'sub_total', 'discount_type', 'discount', 'sale_discount', 'product_discount', 'total_discount',
        'is_include_vat', 'is_include_sc', 'service_charge', 'vat', 'grand_total', 'note', 'creation_by',
        'modified_by', 'is_deleted', 'deleted_by'
    ];

    protected $dates = ['sale_date', 'creation', 'modified'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // public function shift()
    // {
    //     return $this->belongsTo(Shift::class);
    // }

    public function sale_status()
    {
        return $this->belongsTo(SaleStatus::class, 'status_id'); 
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

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }

    public function salePayments()
    {
        return $this->hasMany(SalePayment::class);
    }
}
