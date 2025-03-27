<?php

// app/Models/SalePayment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'payment_date', 'sale_id', 'payment_type_id', 'total_amount', 'total_paid', 'balance',
        'change_amount', 'note', 'creation_by', 'modified_by', 'is_deleted', 'deleted_by'
    ];

    protected $dates = ['payment_date', 'creation', 'modified'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
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
