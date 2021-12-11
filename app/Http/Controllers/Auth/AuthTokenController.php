<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use App\Notifications\TokenNotification;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{
    // public function logintoken(Request $request)
    // {
    //     if (!session('user_id')) {
    //         return redirect('login');
    //     }
    //     session()->reflash();
    //     return view('logintoken');
    // }
    // public function logintokencheck(Request $request)
    // {
    //     $user_id = session()->get('user_id');
    //     $user = User::find($user_id);
    //     $status = Token::verify($user, $request->token);
    //     if ($status) {
    //         $user->tokens()->delete();
    //         auth()->loginUsingId($user_id);
    //         alert()->success('welcome to your panel dear' . ' ' . $user->name);
    //         return redirect('admin/users');
    //     }
    //     $user->tokens()->delete();
    //     auth()->logout();
    //     alert()->error('the token was invalid');
    //     return redirect(route('login'));
    // }
}
