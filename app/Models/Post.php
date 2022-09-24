<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('id', 'title', 'image', 'category_id', 'content', 'publish_date');
   protected $appends = array('is_favourite');
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }


    // public function getThumbnailFullPathAttribute()
    // {
    //     return asset($this->thumbnail);
    // }

    public function getIsFavouriteAttribute()
    {
    // return true;

        // $favourite = request()->user()->whereHas('favourites',function ($query) {
        //     $query->where('client_post.post_id',$this->id);
        // })->first();

        // if ($favourite)
        // {
        //     return true;
        // }
        // return false;
    }

    public function favourites()
    {
        return $this->belongsToMany(Client::class);
    }

}
