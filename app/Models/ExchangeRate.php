<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $table = 'exchangerates';

    protected $fillable = [
        'name',
        'from_currency',
        'to_currency',
        'exchange_rate',
        'note'
    ];

    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from_currency');
    }

    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to_currency');
    }
}
