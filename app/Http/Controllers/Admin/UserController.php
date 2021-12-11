<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\MailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Modules\Action\Entities\Action;
use UxWeb\SweetAlert\SweetAlert;

class UserController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth.admin');
        // $this->middleware('can:admin,user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // auth()->user()->notify(new MailNotification);
        $users = User::query();
        if ($keyword = request('search')) {
            $users->where('email', 'LIKE', "%{$keyword}%")->orWhere('name', 'LIKE', "%{$keyword}%")->orWhere('id', 'LIKE', "%{$keyword}%");
        }
        if (request('admins')) {
            $users->whereAdmin(1);
        }
        $users = $users->latest()->paginate();
        // alert()->success('welcome to your panel dear' . ' ' . auth()->user()->name);
        return view('admin.users.panel', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|string|confirmed',
            'name' => 'required|min:3|max:10',
            'family' => 'required|min:3|max:20',
            'email' => 'required|unique:users',
        ]);
        $data["password"] = Hash::make($data["password"]);
        $user = User::create($data, $request["phone_number"]);

        if ($request->has('verified')) {
            $user->markEmailAsVerified();
        }
        $user->actions()->create([
            'user_id' => auth()->user()->id,
            'object_name' => $user->name,
            'action' => 'create user',
            'date' => now(),
        ]);
        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Gate::denies('admin', $user)) {
            dd('dorud');
        }
        // $this->authorize('admin',$user);
        return view('admin/users/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!$request->password == '') {
            $data = $request->validate([
                'password' => 'required|string|confirmed',
                'name' => 'required|min:3|max:10',
                'family' => 'required|min:3|max:20',
                'email' => ['required', Rule::unique('users')->ignore($user->id)],
                'phone_number' => 'numeric|nullable'
            ]);
        }
        $data = $request->validate([
            'name' => 'required|min:3|max:10',
            'family' => 'required|min:3|max:20',
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'numeric|nullable'
        ]);
        if ($request->has('verified')) {
            $user->markEmailAsVerified();
        } else {
            $user->email_verified_at = null;
        }
        $user->update($data);
        $user->actions()->create([
            'user_id' => auth()->user()->id,
            'object_name' => $user->name,
            'action' => 'update user',
            'date' => now(),
        ]);
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        $user->actions()->create([
            'user_id' => auth()->user()->id,
            'object_name' => $user->name,
            'action' => 'delete user',
            'date' => now(),
        ]);
        return back();
    }
}
