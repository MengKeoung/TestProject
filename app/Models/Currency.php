<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $table = 'currency';

    protected $fillable = ['name', 'symbol'];
    public function paymenttypes()
    {
        return $this->hasMany(PaymentType::class);
    }
    public function fromExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'from_currency');
    }

    public function toExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'to_currency');
    }
}
