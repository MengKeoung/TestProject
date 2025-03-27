<?php

namespace App\Http\Controllers;
use App\Models\Currency;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\PaymentType;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $paymentTypes = PaymentType::all();
        return view('pages.setting.paymentType.index', compact('paymentTypes'));
    }
    public function create()
    {
        $currencies = Currency::pluck('name', 'id'); 
        return view('pages.setting.paymentType.create', compact('currencies'));   
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $paymenttype = new PaymentType;
            $paymenttype->name = $request->name;
            $paymenttype->currency_id = $request->currency;
            $paymenttype->status = $request->status;
            $paymenttype->save();

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
        $paymenttype = PaymentType::find($id);
        $currencies = Currency::pluck('name', 'id');
        return view('pages.setting.paymenttype.edit', compact('paymenttype', 'currencies'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'currency_id' => 'required|exists:currency,id', // Ensure the currency exists
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }
    
        try {
            DB::beginTransaction();
    
            $paymenttype = PaymentType::find($id);
            $paymenttype->name = $request->name;
            $paymenttype->currency_id = $request->currency_id;  // Use currency_id here
            $paymenttype->status = $request->status;
            $paymenttype->save();
    
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
            $paymenttype = PaymentType::findOrFail($id);
            $paymenttype->delete();
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
