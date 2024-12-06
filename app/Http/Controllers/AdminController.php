<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('myAdmin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid name or password');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
    }

    public function index()
    {
        $admins = Admin::all();
        return view('myAdmin.admin.index', compact('admins'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'password' => 'required|min:8',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.admin')->with('success', 'Admin successfuly created');
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->is_root) {
            return redirect()->route('admin.admin')->with('error', 'Cannot modify root admin');
        }

        $request->validate([
            'name' => 'required|max:255',
            'password' => 'required|min:8',
        ]);

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
