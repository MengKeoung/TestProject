<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Role;
use App\helpers\ImageManager;


class UserController extends Controller
{
    public function index()
    {
        if(!auth()->user()->can('user.view')) {
            abort(403,'Unauthorized action.');
        }
        // Eager load the 'roles' relationship
        $users = User::latest('id')->with('roles')->paginate(10);
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
        if(!auth()->user()->can('user.create')) {
            abort(403,'Unauthorized action.');
        }
        $roles = Role::select('name','id')
                ->pluck('name','id');
        return view('pages.users.create', compact('roles'));
    }

    public function store(Request $request)
{
    if(!auth()->user()->can('user.create')) {
        abort(403,'Unauthorized action.');
    }
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'role' => 'required|exists:roles,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image
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
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->telegram = $request->telegram;
        $user->user_id = $request->user_id;

        $role = Role::findOrFail($request->role);
        $user->assignRole($role->name);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $imagePath = ImageManager::upload('uploads/users/', $request->file('image'));

            if ($imagePath) {
                $user->image = $imagePath;
            } else {
                throw new Exception('Image upload failed');
            }
        }

        $user->save();

        DB::commit();

        return redirect()->route('admin.users.index')->with([
            'success' => 1,
            'msg' => __('User created successfully'),
        ]);

    } catch (Exception $e) {
        DB::rollBack();
        Log::error('User creation failed: ' . $e->getMessage());

        return redirect()->back()->with([
            'success' => 0,
            'msg' => __('Something went wrong: ') . $e->getMessage(),
        ]);
    }
}
    public function edit($id)
    {
        if(!auth()->user()->can('user.edit')) {
            abort(403,'Unauthorized action.');
        }
        $user = User::findOrFail($id);
        $roles = Role::select('name','id')->pluck('name','id');

        return view('pages.users.edit', compact('user', 'roles'));
    }
    public function update(Request $request, $id)
{
    if(!auth()->user()->can('user.edit')) {
        abort(403,'Unauthorized action.');
    }
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|exists:roles,id',
        // 'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Add validation for image
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with(['success' => 0, 'msg' => __('Invalid form input')]);
    }

    try {
        DB::beginTransaction();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password ? bcrypt($request->password) : $user->password; // Update password only if provided
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->telegram = $request->telegram;
        $user->user_id = $request->user_id;

        // Handle image upload if there's a new image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && file_exists(public_path('uploads/users/' . $user->image))) {
                unlink(public_path('uploads/users/' . $user->image));
            }
            // Save new image
            $user->image = ImageManager::upload('uploads/users/', $request->image); // Assuming ImageManager handles the upload
        }

        $role = Role::findOrFail($request->role);
        $user->syncRoles($role->name);  // Sync roles to avoid duplicates

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

    return redirect()->route('admin.users.index')->with($output);
}

    public function destroy($id)
    {
        if(!auth()->user()->can('user.delete')) {
            abort(403,'Unauthorized action.');
        }
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

        return redirect()->route('admin.users.index')->with($output);
    }
}
