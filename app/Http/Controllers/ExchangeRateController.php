<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\DB;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $exchangeRates = ExchangeRate::with(['fromCurrency', 'toCurrency'])->get();
        return view('exchangeRate.index', compact('exchangeRates'));
    }
    public function create()
    {
        $currencies = Currency::pluck('name', 'id');
        return view('pages.setting.exchangeRate.create', compact('currencies'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'exchange_rate' => 'required',
                'from_currency' => 'required',
                'to_currency' => 'required',
            ]);

            $exchangeRate = new ExchangeRate();
            $exchangeRate->name = $request->name;
            $exchangeRate->exchange_rate = $request->exchange_rate;
            $exchangeRate->from_currency = $request->from_currency;
            $exchangeRate->to_currency = $request->to_currency;
            $exchangeRate->note = $request->note;

            $exchangeRate->save();

            return redirect()->route('admin.setting.index')->with('success', 'Exchange Rate created successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.setting.index')->with('error', 'Failed to create Exchange Rate: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $exchangeRate = ExchangeRate::findorFail($id);
        $currencies = Currency::pluck('name', 'id');
        return view('pages.setting.exchangeRate.edit', compact('exchangeRate', 'currencies'));
    }
    public function update(Request $request, $id)
{
    try {
  
        $request->validate([
            'name' => 'required',
            'exchange_rate' => 'required',
            'from_currency' => 'required',
            'to_currency' => 'required',
        ]);
        DB::beginTransaction();

        $exchangeRate = ExchangeRate::findOrFail($id);

        $exchangeRate->exchange_rate = str_replace(',', '', $request->exchange_rate);
        $exchangeRate->name = $request->name;
        $exchangeRate->from_currency = $request->from_currency;
        $exchangeRate->to_currency = $request->to_currency;
        $exchangeRate->note = $request->note;

        $exchangeRate->save();
        DB::commit();

        return redirect()->route('admin.setting.index')->with('success', 'Exchange Rate updated successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error("Failed to update Exchange Rate: " . $e->getMessage());
        return redirect()->route('admin.setting.index')->with('error', 'Failed to update Exchange Rate: ' . $e->getMessage());
    }
}

    public function destroy($id)
    {
        try {
            $exchangeRate = ExchangeRate::find($id);
            $exchangeRate->delete();

            return redirect()->route('admin.setting.index')->with('success', 'Exchange Rate deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.setting.index')->with('error', 'Failed to delete Exchange Rate: ' . $e->getMessage());
        }
    }
}
