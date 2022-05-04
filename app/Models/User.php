<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'contact',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    public function shoppingSession()
    {
        return $this->hasOne(ShoppingSession::class, 'user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }

    public function productRatings()
    {
        return $this->hasMany(ProductRating::class, 'user_id');
    }

    public function questionAnswers()
    {
        return $this->hasMany(QuestionAnswer::class, 'user_id');
    }
}
