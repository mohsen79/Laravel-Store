<?php

namespace Modules\Token\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Token\Entities\Token;

class LoginTwoFactController extends Controller
{
    public function logintoken(Request $request)
    {
        if (!session('user_id')) {
            return redirect('login');
        }
        session()->reflash();
        return view('logintoken');
    }
    public function logintokencheck(Request $request)
    {
        $user_id = session()->get('user_id');
        $user = User::find($user_id);
        $status = Token::verify($user, $request->token);
        if ($status) {
            $user->tokens()->delete();
            auth()->loginUsingId($user_id);
            alert()->success('welcome to your panel dear' . ' ' . $user->name);
            return redirect('admin/users');
        }
        $user->tokens()->delete();
        auth()->logout();
        alert()->error('the token was invalid');
        return redirect(route('login'));
    }
}
