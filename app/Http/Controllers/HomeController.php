<?php

namespace App\Http\Controllers;
use App\Models\Products;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productCount = Products::count();
        $customerCount = Customer::count();
        $userCount = User::count();
        return view('pages.home', compact('productCount', 'customerCount', 'userCount'));
    }
    
   
}
