<?php

namespace App\Models;

use Spatie\Permission\Models\role as Model;

class Role extends Model
{
    protected $fillable=['name','guard_name','display_name','description'];
}
