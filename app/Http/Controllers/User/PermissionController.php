<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Boss');
    }
    public function index(User $user)
    {
        return view('admin/users/permissions', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions);
        return redirect('admin/users');
    }
}
