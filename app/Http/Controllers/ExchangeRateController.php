<?php

namespace App\Http\Controllers;
use App\Models\Currency;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index()
    {
        return view('exchangeRate.index');
    }
    public function create()
    {
        $currencies = Currency::pluck('name', 'id'); 
        return view('pages.setting.exchangeRate.create', compact('currencies'));
    }
}
