<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    // It looks for id so we overwrite the route and search by slug
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
