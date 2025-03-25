<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Customercontroller extends Controller
{
    public function index()
    {
        if(!auth()->user()->can('customer.view')) {
            abort(403,'Unauthorized action.');
        }
        $customers = Customer::all();
        return view('pages.customers.index', compact('customers'));
    }
    public function create()
    {
        if(!auth()->user()->can('customer.create')) {
            abort(403,'Unauthorized action.');
        }
        return view('pages.customers.create');
    }
    public function store(Request $request)
    {
        if(!auth()->user()->can('customer.create')) {
            abort(403,'Unauthorized action.');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            
            $customer->save();
            
            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('Create successfully'),
            ];

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in saving Customer: ' . $e->getMessage());
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }
        return redirect()->route('admin.customers.index')->with($output);
    }
    public function edit($id)
    {
        if(!auth()->user()->can('customer.edit')) {
            abort(403,'Unauthorized action.');
        }
        $customer = Customer::find($id);
        return view('pages.customers.edit', compact('customer'));
    }
    public function update(Request $request, $id)
    {
        if(!auth()->user()->can('customer.edit')) {
            abort(403,'Unauthorized action.');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $customer = Customer::find($id);
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            
            $customer->save();
            
            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('Update successfully'),
            ];

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in saving Customer: ' . $e->getMessage());
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }
        return redirect()->route('admin.customers.index')->with($output);
    }
    public function destroy($id)
    {
        if(!auth()->user()->can('customer.delete')) {
            abort(403,'Unauthorized action.');
        }
        try {
            DB::beginTransaction();
            $customer = Customer::findOrFail($id);
            $customer->delete();
          
            DB::commit();
            $output = [
                'status' => 1,
                'msg' => __('Deleted successfully')
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $output = [
                'status' => 0,
                'msg' => __('Something went wrong')
            ];
        }
        
        return redirect()->route('admin.customers.index')->with($output);
        
    }
}
