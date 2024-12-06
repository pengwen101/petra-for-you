<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('myAdmin.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string',
        ], [
            'name.required' => 'Please enter your username.',
            'password.required' => 'Please enter your password.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.login')
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $credentials = $request->only('name', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                return back()->with('error', 'Your account is not active.');
            }

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid username or password.');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return back();
    }

    public function index()
    {
        $admins = Admin::all(['id', 'name', 'active'])->sortByDesc('created_at');
        return view('myAdmin.admin.admin', compact('admins'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.admin')
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.admin')->with('success', 'Admin successfully created');
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->is_root) {
            return redirect()->route('admin.admin')->with('error', 'Cannot modify root admin');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'password' => 'nullable|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.admin')
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $adminData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $adminData['password'] = bcrypt($request->password);
        }

        $admin->update($adminData);

        return redirect()->route('admin.admin')->with('success', 'Admin successfully updated');
    }

    public function remove($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->is_root) {
            return redirect()->route('admin.admin')->with('error', 'Cannot deactivate root admin');
        }

        $admin->update(['active' => false]);

        return redirect()->route('admin.admin')->with('success', 'Admin successfully deactivated');
    }
}
