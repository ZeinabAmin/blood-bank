<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{

    protected $table = 'blood_types';
    public $timestamps = true;
    protected $fillable = array('id', 'name');

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function bloodTypeClients()
    {
        return $this->belongsToMany('App\Models\Client');
    }

}
