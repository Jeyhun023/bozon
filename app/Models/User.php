<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'active', 'thumb_nail',
        'customer_code', 'phone_number',
        'photo', 'ip_address', 'last_login', 'seller_id'
    ];

    protected $guard_name = 'api';

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'ip_address', 'last_login'
    ];

    public function getPhotoAttribute($value)
    {
        return !is_null($value) ? asset('uploads/users/' . $value) : null;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'seller_id', 'id')->selectRaw('avg(seller_rate) as aggregate, seller_id')->groupBy('seller_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function detail()
    {
        return $this->belongsTo(Stores::class, 'seller_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
