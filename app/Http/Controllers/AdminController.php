<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_admin' => 'required|string|max:255',
            'email'      => 'required|email|unique:admins,email',
            'password'   => 'required|string|min:6',
            'type'       => 'nullable|string|max:255',
        ]);

        $data['password'] = bcrypt($data['password']);
        // default 'admin' jika kosong
        $data['type'] = $data['type'] ?? 'admin';

        Admin::create($data);

        return redirect()->route('admin.index')
                         ->with('success', 'Admin created.');
    }

    public function show(Admin $admin)
    {
        return view('admin.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'nama_admin' => 'required|string|max:255',
            'email'      => 'required|email|unique:admins,email,'.$admin->admin_id.',admin_id',
            'password'   => 'nullable|string|min:6',
            'type'       => 'nullable|string|max:255',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        // tetap default 'admin' jika tidak diubah
        $data['type'] = $data['type'] ?? $admin->type;

        $admin->update($data);

        return redirect()->route('admin.index')
                         ->with('success', 'Admin updated.');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admin.index')
                         ->with('success', 'Admin deleted.');
    }
}
