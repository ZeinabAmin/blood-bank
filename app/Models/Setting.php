<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('id', 'notification_settings_text', 'about_app','intro', 'phone', 'email', 'fb_link', 'tw_link', 'insta_link', 'youtube_link','whatsapp_link','contact_us_text','mobile_app_text','mobile_app_android_link','mobile_app_ios_link');

}
