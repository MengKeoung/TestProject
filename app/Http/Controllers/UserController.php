<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;



class UserController extends Controller
{
    public function index()
    {
        $users = User::latest('id')->paginate(10);
        return view('pages.users.index', compact('users'));
    }
    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->orderBy('id', 'desc')
            ->paginate(10); 

        return view('pages.users.table', compact('users', 'search'))->render(); // Pass the paginated results to the view
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

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
        return redirect()->route('pages.users.index')->with($output);
    }
    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['success' => 0, 'msg' => __('Invalid form input')]);
        }

        try {
            DB::beginTransaction();

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

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

        return redirect()->route('pages.users.index')->with($output);
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $user = User::find($id);
            $user->delete();

            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('Delete successfully'),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }

        return redirect()->route('pages.users.index')->with($output);
    }
}
