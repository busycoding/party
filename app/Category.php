<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['title', 'slug'];
	
    public function companies() {
    	return $this->hasMany(Company::class);
    }
    // video 18 where we get url by slug
    public function getRouteKeyName() {
    	return 'slug';
    }
}
