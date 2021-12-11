<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Psy\Util\Str;

class GoogleAuthController extends Controller
{
    use TwoFactAuthenticat;
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback(Request $request)
    {
        $google_user = Socialite::driver('google')->user();
        if ($user = User::where('email', $google_user->email)->first()) {
            auth()->loginUsingId($user->id);
        } else {
            $user = User::create([
                'name' => $google_user->name,
                'email' => $google_user->email,
                'password' => bcrypt(\Str::random(16)),
                'two_fact_auth' => 'off',
            ]);
            auth()->loginUsingId($user->id);
        }
        $user->markEmailAsVerified();
        if ($user->two_fact_auth == 'on') {
            return $this->loggedin($request, $user) ?:
                alert()->success('welcome to your panel dear ' . auth()->user()->name);
            redirect('admin/users');
        }
        alert()->success('welcome to your panel dear ' . auth()->user()->name);
        return redirect('admin/users');
    }
}
