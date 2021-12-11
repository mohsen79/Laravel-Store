<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    protected $fillable = ['token', 'expired'];
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
}
