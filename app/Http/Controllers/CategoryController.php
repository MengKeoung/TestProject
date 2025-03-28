<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        if(!auth()->user()->can('category.view')) {
            abort(403,'Unauthorized action.');
        }
        $categories = Category::all();
        return view('pages.categories.index', compact('categories'));
    }
    public function create()
    {
        if(!auth()->user()->can('category.create')) {
            abort(403,'Unauthorized action.');
        }
        return view('pages.categories.create');
    }
    public function store(Request $request)
    {
        if(!auth()->user()->can('category.create')) {
            abort(403,'Unauthorized action.');
        }
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

            $category = new Category;
            $category->name = $request->name;
            $category->status = $request->status;
            $category->save();

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

        return redirect()->route('admin.categories.index')->with($output);
    }
    public function edit($id)
    {
        if(!auth()->user()->can('category.edit')) {
            abort(403,'Unauthorized action.');
        }
        $category = Category::find($id);
        return view('pages.categories.edit', compact('category'));
    }
    public function update(Request $request, $id)
    {
        if(!auth()->user()->can('category.edit')) {
            abort(403,'Unauthorized action.');
        }
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

            $category = Category::find($id);
            $category->name = $request->name;
            $category->status = $request->status;
            $category->save();

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

        return redirect()->route('admin.categories.index')->with($output);
    }
    public function destroy($id)
    {
        if(!auth()->user()->can('category.delete')) {
            abort(403,'Unauthorized action.');
        }
        try {
            DB::beginTransaction();
            $category = Category::findOrFail($id);
            $category->delete();
          
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
        
        return redirect()->route('admin.categories.index')->with($output);
        
    }
    public function updateStatus (Request $request)
    {
        try {
            DB::beginTransaction();

            $category = Category::findOrFail($request->id);
            $category->status = $category->status == 1 ? 0 : 1;
            $category->save();

            $output = ['status' => 1, 'msg' => __('Status updated')];

            DB::commit();
        } catch (Exception $e) {

            $output = ['status' => 0, 'msg' => __('Something went wrong')];
            DB::rollBack();
        }

        return response()->json($output);
    }
}