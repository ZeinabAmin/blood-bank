<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable{


    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('id', 'phone', 'email', 'blood_type_id', 'password', 'name', 'date_of_birth', 'city_id',
    'last_donation_date','is_active');

    // public function setPasswordAttribute($value)
    // {
    //    $this->attributes['password']=bcrypt($value);
    // }


    public function clientBloodTypes()
    {
        return $this->belongsToMany('App\Models\BloodType');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function donationRequest()
    {
        return $this->hasMany('App\Models\DonationRequest');
    }

    public function contact()
    {
        return $this->hasMany('App\Models\Contact');
    }

    public function bloodType()
    {
        return $this->belongsTo('App\Models\BloodType');
    }

    public function governorates()
    {
        return $this->belongsToMany('App\Models\Governorate');
    }

    public function favourites()
    {
        return $this->belongsToMany('App\Models\post');
    }


    public function clientGovernorates()
    {
        return $this->belongsToMany('App\Models\Governorate');
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Models\Notification')->withPivot('is_seen');
    }



    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }
    protected $hidden = [
        'password',
        'api_token',
    ];

}
