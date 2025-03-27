<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use App\Models\SaleProduct;
use App\Models\PaymentType;
use App\Models\ExchangeRate;
use App\Models\SalePayment;

class PosController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['sale_status'])->latest()->get();
        $sale_products = SaleProduct::all();
        $customers = Customer::all();

        return view('pages.pos.allsales', compact('sales', 'customers', 'sale_products'));
    }
    public function create()
    {
        $customers = Customer::all();
        $categories = Category::all();
        $paymenttypes = PaymentType::all();
        $exchangeRates = ExchangeRate::all();
        return view('pages.pos.index', compact('categories', 'customers', 'paymenttypes', 'exchangeRates'));
    }
    public function searchProduct(Request $request)
    {
        $searchQuery = $request->input('search_query');

        $products = Products::where('product_name', 'like', '%' . $searchQuery . '%')
            ->get(['id', 'product_name', 'price', 'price_after_discount', 'qty']);

        return response()->json($products);
    }
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'total_quantity' => 'required|integer|min:1',
            'sub_total'     => 'required|numeric|min:0',
            'grand_total'   => 'required|numeric|min:0',
            'products'      => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'payments'          => 'nullable|array|min:1',  
            'payments.*.payment_type_id' => 'required|exists:payment_types,id',
            'payments.*.amount' => 'required|numeric|min:0.01', 
        ]);
    
        $lastSale = Sale::latest()->first(); 
        if ($lastSale) {
            $lastInvoiceNumber = intval(substr($lastSale->sale_code, 4));
            $newInvoiceNumber = str_pad($lastInvoiceNumber + 1, 7, '0', STR_PAD_LEFT); 
        } else {
            $newInvoiceNumber = '0000001'; 
        }
        $invoiceNo = 'INV-' . $newInvoiceNumber;
   
        $lastSaleProduct = SaleProduct::latest()->first();
        if ($lastSaleProduct) {
            $lastSaleProductNumber = intval(substr($lastSaleProduct->name, 4)); // Extract number part
            $newSaleProductNumber = str_pad($lastSaleProductNumber + 1, 7, '0', STR_PAD_LEFT);
        } else {
            $newSaleProductNumber = '0000001'; 
        }
        $saleproductname = 'SAP-' . $newSaleProductNumber;
    
        $lastSalePayment = SalePayment::latest()->first();
        if ($lastSalePayment) {
            $lastSalePaymentNumber = intval(substr($lastSalePayment->payment_code, 4)); // Extract number part
            $newSalePaymentNumber = str_pad($lastSalePaymentNumber + 1, 7, '0', STR_PAD_LEFT);
        } else {
            $newSalePaymentNumber = '0000001'; 
        }
        $paymentCode = 'PAY-' . $newSalePaymentNumber;

        DB::beginTransaction();
        try {
            // Save the sale
            $sale = Sale::create([
                'sale_code' => $invoiceNo,
                'customer_id' => $validatedData['customer_id'],
                'total_quantity' => $validatedData['total_quantity'],
                'sale_discount' => $request->discount ?? 0, // Ensure discount is set properly
                'sub_total' => $validatedData['sub_total'],
                'grand_total' => $validatedData['sub_total'] - ($request->discount ?? 0),
                'creation_by' => auth()->user()->id,
                'modified_by' => auth()->user()->id,
                'deleted_by' => auth()->user()->id,
            ]);
    
            // Save each product
            foreach ($validatedData['products'] as $product) {
                SaleProduct::create([
                    'name' => $saleproductname,
                    'sale_id' => $sale->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['qty'],
                    'price' => $product['price'],
                    'total_amount' => $product['qty'] * $product['price'],
                    'creation_by' => auth()->user()->id,
                    'modified_by' => auth()->user()->id,
                    'deleted_by' => auth()->user()->id,
                ]);
            }
            if (!empty($validatedData['payments'])) {
                foreach ($validatedData['payments'] as $payment) {
                    SalePayment::create([
                        'payment_date'  => now(),
                        'name'          => $paymentCode,
                        'sale_id'      => $sale->id,
                        'payment_type_id' => $payment['payment_type_id'],
                        'amount'          => $payment['amount'], 
                        'creation_by'     => auth()->user()->id,
                        'modified_by'     => auth()->user()->id,
                        'deleted_by'      => auth()->user()->id,
                    ]);
                }
            }
    
            DB::commit();
    
            return response()->json([
                'message' => 'Sale recorded successfully!',
                'sale' => $sale
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
}
