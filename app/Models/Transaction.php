<?php

namespace App\Models;

use App\Models\TransactionSellLine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionSellLines()
    {
        return $this->hasMany(TransactionSellLine::class);
    }

    public function createdBy ()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
