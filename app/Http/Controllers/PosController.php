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
        return view('pages.pos.index', compact('categories', 'customers', 'paymenttypes'));
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
        // 'sale_discount' => 'required|numeric|min:0',
        'sub_total'     => 'required|numeric|min:0',
        'grand_total'   => 'required|numeric|min:0',
        'products'      => 'required|array|min:1',
        'products.*.id' => 'required|exists:products,id',
        'products.*.qty' => 'required|integer|min:1',
        'products.*.price' => 'required|numeric|min:0',
    ]);


    $invoiceNo = 'INV-' . strtoupper(uniqid());
    $saleproductname = 'SAP-' . strtoupper(uniqid());

    DB::beginTransaction();
    try {
        // Save the sale
        $sale = Sale::create([
            'sale_code' => $invoiceNo,
            'customer_id' => $validatedData['customer_id'],
            'total_quantity' => $validatedData['total_quantity'],
            'sale_discount' => $request->discount, // Make sure this value is passed correctly
            'sub_total' => $validatedData['sub_total'],
            'grand_total' => $validatedData['sub_total'] - $request->discount,
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
            ]);

            // Deduct stock if applicable
            // $productModel = Products::find($product['id']);
            // if ($productModel) {
            //     $productModel->decrement('stock', $product['qty']);
            // }
        }

        DB::commit();

        return response()->json([
            'message' => 'Sale recorded successfully!',
            'sale' => $sale
        ], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Something went wrong!'], 500);
    }
}

}
