<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\PaymentType;
use App\Models\Setting;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class SettingController extends Controller
{
    public function index()
{
    if(!auth()->user()->can('setting.view')) {
        abort(403,'Unauthorized action.');
    }

    // Retrieve the first settings record, or create a default one if it doesn't exist
    $settings = Setting::first();

    if (!$settings) {
        // Optionally, create a default settings record if none exists
        $settings = new Setting();
        $settings->english_name = '';  // Set default values as necessary
        $settings->khmer_name = '';
        $settings->phone = '';
        $settings->gmail = '';
        $settings->address = '';
        $settings->tax = 0;
        $settings->vattin_number = '';
        $settings->copyright = '';
        $settings->logo = null;  // Or set a default logo if necessary
        // You can save the default settings or handle this differently
        $settings->save();
    }

    $currencies = Currency::all();
    $paymentTypes = PaymentType::all();
    $exchangeRates = ExchangeRate::all();

    return view('pages.setting.index', compact('currencies', 'paymentTypes', 'settings', 'exchangeRates'));
}

    public function update()
    {
        if(!auth()->user()->can('setting.edit')) {
            abort(403,'Unauthorized action.');
        }
        $validator = Validator::make(request()->all(), [
            'english_name' => 'required|string|max:255',
            'khmer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'gmail' => 'required|email|max:255',
            'vattin_number' => 'required|string|max:255',
            'tax' => 'required|numeric',
            'copyright' => 'required|string|max:255',
            'address' => 'required|string',
            'web_header_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for image file
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }
    
        try {
            DB::beginTransaction();
            $setting = Setting::first(); // Assuming there is only one setting
    
            // Update the other fields
            $setting->english_name = request()->english_name;
            $setting->khmer_name = request()->khmer_name;
            $setting->phone = request()->phone;
            $setting->gmail = request()->gmail;
            $setting->vattin_number = request()->vattin_number;
            $setting->tax = request()->tax;
            $setting->copyright = request()->copyright;
            $setting->address = request()->address;
    
            // Handle the logo upload if a new file is uploaded
            if (request()->hasFile('web_header_logo')) {
                $logo = request()->file('web_header_logo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('uploads/settings'), $logoName);
    
                // Optionally, delete the old logo if you want to replace it
                if ($setting->logo && file_exists(public_path('uploads/settings/' . $setting->logo))) {
                    unlink(public_path('uploads/settings/' . $setting->logo));
                }
    
                // Save the new logo path to the database
                $setting->logo = $logoName;
            }
    
            // Save the setting updates
            $setting->save();
            DB::commit();
    
            $output = [
                'success' => 1,
                'msg' => __('Update successfully'),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating settings: ' . $e->getMessage()); // Log the error for debugging
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }
    
        if (request()->ajax()) {
            return response()->json($output);
        }
    
        return redirect()->route('admin.setting.index')->with($output);
    }
    
}
