<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;


class PosController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $categories = Category::all();
        return view('pages.pos.index', compact('categories', 'customers'));
    }
    public function searchProduct(Request $request)
{
    // Get the search query from the request
    $searchQuery = $request->input('search_query');
    
    // Filter products based on the search query and return only the id, product_name, and price
    $products = Products::where('product_name', 'like', '%' . $searchQuery . '%')
        ->get(['id', 'product_name', 'price', 'qty']); // Return id, name, and price
    
    // Return the results as a JSON response
    return response()->json($products);
}

    


}
