<?php

namespace App\Http\Controllers\Auth;

use App\Models\Token;
use App\Notifications\TokenNotification;
use Illuminate\Http\Request;

trait TwoFactAuthenticat
{
    // public function loggedin(Request $request, $user)
    // {
    //     if ($user->two_fact_auth == 'on') {
    //         $request->session()->flash('user_id', auth()->user()->id);
    //         auth()->logout();
    //         $token = Token::generatecode($user);
    //         alert()->info('we sent token to you it will be valid until 1 minute')->autoclose(5000);
    //         // $user->notify(new TokenNotification($token, $user->phone_number));
    //         return redirect('auth/login/token');
    //     }
    //     return false;
    // }
}
