<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Action\Entities\Action;
use Modules\Comment\Entities\Comment;
use Modules\Token\Entities\Token;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'password_confirmation',
        'two_fact_auth',
        'family'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function hasTwoFact($key)
    {
        return $this->two_fact_auth == $key;
    }
    public function tokens()
    {
        return $this->hasMany(Token::class);
    }
    public function IsAdmin()
    {
        return $this->admin;
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function HasRole($role)
    {
        return $this->roles->contains('id', $role->id);
    }
    public function HasPermission($permission)
    {
        return $this->permissions->contains('name', $permission->name);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable');
    }
    // public function actions()
    // {
    //     return $this->hasMany(Action::class);
    // }
    public function actions()
    {
        return $this->morphMany(Action::class, 'actionable');
    }
}
