<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();
        return view('pages.setting.currency.index', compact('currencies'));
    }
    public function create()
    {
        return view('pages.setting.currency.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'symbol' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $currency = new Currency;
            $currency->name = $request->name;
            $currency->symbol = $request->symbol;
            $currency->save();

            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('Create successfully'),
            ];

        } catch (Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];  
        }
        return redirect()->route('admin.setting.index')->with($output);
    }
    public function edit($id)
    {
        $currency = Currency::find($id);
        return view('pages.setting.currency.edit', compact('currency'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'symbol' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }    

        try {
            DB::beginTransaction();

            $currency = Currency::find($id);
            $currency->name = $request->name;
            $currency->symbol = $request->symbol;
            $currency->save();            

            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('Update successfully'),
            ];

        } catch (Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];  
        }
        return redirect()->route('admin.setting.index')->with($output);
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $currency = Currency::findOrFail($id);
            $currency->delete();
            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Deleted successfully')
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong')
            ];
        }
        return redirect()->route('admin.setting.index')->with($output);
    }
}
