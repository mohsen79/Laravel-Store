<?php

namespace Modules\Token\Entities;

use App\Models\User;
use App\Notifications\TokenNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class Token extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token', 'expired'];
    public $timestamps = false;
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeGenerateCode($query, $user)
    {
        $token = mt_rand(10000, 99999);
        $user->tokens()->create([
            'token' => $token,
            'expired' => now()->addMinutes(1)
        ]);
        return $token;
    }
    public function scopeVerify($query, $user, $token)
    {
        return !!$user->tokens()->whereToken($token)->where('expired', '>', now())->first();
    }

    public function scopeLoggedin($query, Request $request, $user)
    {
        if ($user->two_fact_auth == 'on') {
            $request->session()->flash('user_id', auth()->user()->id);
            auth()->logout();
            $token = $this->generatecode($user);
            alert()->info('we sent token to you it will be valid until 1 minute')->autoclose(5000);
            // $user->notify(new TokenNotification($token, $user->phone_number));
            return redirect('auth/login/token');
        }
        return false;
    }
    protected static function newFactory()
    {
        return \Modules\Token\Database\factories\TokenFactory::new();
    }
}
