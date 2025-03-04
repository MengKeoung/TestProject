<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\products;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Products::latest('id')->paginate(10);
        return view('pages.products.index', compact('products', 'categories'));
    }
    public function search(Request $request)
    {
        $search = $request->input('search');

        $products = Products::with('category') // Eager load category
            ->where('product_name', 'like', "%{$search}%")
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%"); // Assuming category table has 'name' field
            })
            ->orderBy('id', 'desc')
            ->paginate(10); // Use paginate instead of get() for pagination

        return view('pages.products.table', compact('products', 'search'))->render(); // Pass the paginated products to the view
    }
    public function filterProducts(Request $request)
    {
        $categoryId = $request->input('category_id');

        $products = Products::with('category') // Make sure it's Product, not Products
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->paginate(10); // Use pagination if you're using it in the view

        return view('pages.products.table', compact('products'))->render();
    }

    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('pages.products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'product_name' => 'required',
            // 'category_id' => 'required',
            // 'price' => 'required',
            // 'qty' => 'required',
            //  'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $product = new products();
            $product->product_name = $request->product_name;
            $product->category_id = $request->category;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $product->description = $request->description;
            $product->discount_type = $request->discount_type;
            $product->discount = $request->discount;
            $product->status = $request->status;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $directory = public_path('uploads/products');

                // Make sure the directory exists
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0777, true);
                }

                // Move the image
                $image->move($directory, $imageName);

                // Save image name in the database
                $product->image = $imageName;
            }
            $product->save();
            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('Create successfully'),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in saving product: ' . $e->getMessage());
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }


        return redirect()->route('pages.products.index')->with($output);
    }
    public function edit($id)
    {
        $product = products::find($id);
        $categories = Category::pluck('name', 'id');
        return view('pages.products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'product_name' => 'required',
            // 'category_id' => 'required',
            // 'price' => 'required',
            // 'qty' => 'required',
            //  'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $product = products::find($id);
            $product->product_name = $request->product_name;
            $product->category_id = $request->category;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $product->description = $request->description;
            $product->discount_type = $request->discount_type;
            $product->discount = $request->discount;
            $product->status = $request->status;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $directory = public_path('uploads/products');

                // Make sure the directory exists
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0777, true);
                }

                // Move the image
                $image->move($directory, $imageName);

                // Save image name in the database
                $product->image = $imageName;
            }
            $product->save();
            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('Update successfully'),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in saving product: ' . $e->getMessage());
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }


        return redirect()->route('pages.products.index')->with($output);
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $product = products::findOrFail($id);
            $product->delete();

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

        return redirect()->route('pages.products.index')->with($output);
    }
    public function updateStatus (Request $request)
    {
        try {
            DB::beginTransaction();

            $product = Products::findOrFail($request->id);
            $product->status = $product->status == 1 ? 0 : 1;
            $product->save();

            $output = ['status' => 1, 'msg' => __('Status updated')];

            DB::commit();
        } catch (Exception $e) {

            $output = ['status' => 0, 'msg' => __('Something went wrong')];
            DB::rollBack();
        }

        return response()->json($output);
    }
}
