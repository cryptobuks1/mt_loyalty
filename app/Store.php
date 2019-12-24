<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Store extends Model
{
    use HasApiTokens,SoftDeletes,Notifiable;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'phone_number',
        'country_code',
        'email',
        'facebook_url',
        'location_address',
        'latitude',
        'longitude'
    ];
    protected $dates = ['deleted_at'];

    public function merchant(){
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function user_stemp_count(){
        return $this->hasOne(UserStampCollect::class,'id','store_id');
    }
}