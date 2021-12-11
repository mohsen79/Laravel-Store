<?php

namespace Modules\Token\Http\Controllers;

use App\Models\User;
use App\Notifications\TokenNotification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Token\Entities\Token;

class TokenController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }
    public function show()
    {
        return view('auth/TwoFactAuth');
    }
    public function update(Request $request)
    {
        if ($request->two_fact_auth == 'off') {
            User::find($request->user()->id)->update([
                'two_fact_auth' => 'off',
                'phone_number' => $request->phone_number
            ]);
            return back();
        }
        $request->validate([
            'two_fact_auth' => 'required|in:off,on',
            'phone_number' => ['required_if:two_fact_auth,on', Rule::unique('users', 'phone_number')->ignore($request->user()->id)],
        ]);
        if (auth()->user()->phone_number != $request["phone_number"]) {
            $request->session()->flash('phone_number', $request->phone_number);
            $token = Token::generateCode(auth()->user());
            alert()->info('we sent token to you it will be valid until 1 minute')->autoclose(5000);
            $request->user()->notify(new TokenNotification($token, $request->phone_number));
            return redirect('user/token');
        }
        User::find($request->user()->id)->update([
            'two_fact_auth' => $request->two_fact_auth,
        ]);

        return back();
    }
    public function token(Request $request)
    {
        if (!$request->session()->has('phone_number')) {
            return redirect('user/twofactauth');
        }
        $request->session('phone_number')->reflash();
        return view('auth/Token');
    }
    public function check(Request $request, $user)
    {
        if (!$request->session()->has('phone_number')) {
            return redirect('user/twofactauth');
        }
        $request->validate([
            'token' => 'required|numeric|exists:tokens,token'
        ]);
        $user = User::find($user);
        $status = Token::verify($user, $request->token);
        if ($status) {
            $user = auth()->user();
            User::find($user->id)->update([
                'two_fact_auth' => 'on',
                'phone_number' => $request->session('phone_number')->get('phone_number'),
            ]);
            $request->session()->forget('phone_number');
            $user->tokens()->delete();
            return redirect('admin/users');
        } else {
            $user->tokens()->delete();
            alert()->error('the code has terminated');
            $request->session()->forget('phone_number');
            return redirect('user/twofactauth');
        }
    }
}
