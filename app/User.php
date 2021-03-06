<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,SoftDeletes,Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'profile_picture',
        'is_aggree_terms',
        'phone_number',
        'country_code',
        'unique_token',
        'fbid',
        'gid',
        'tid',
        'is_active',
        'birthdate',
        'gender',
        'is_notification'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['country_code_name'];

    public function devices(){
        return $this->hasMany(UserDevice::class, 'user_id', 'id');
    }

    public function getCounrtyData(){
        return $this->hasOne(Country::class, 'id', 'country_code');
    }

    public function getCountryCodeNameAttribute(){
        if(!empty($this->getCounrtyData)){
            return $this->getCounrtyData->phonecode;
        }else{
            return "";
        }
    }
    public function store(){
        return $this->hasOne(Store::class);
    }

    public function wallets(){
        return $this->belongsToMany(Store::class)->withTimestamps();
    }

    public function getProfilePictureAttribute($value) {
        return $value ? asset('/uploads/user') . "/" .  $value : "";
    }

}
