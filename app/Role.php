<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
	// TODO: not even sure if fillable works here, remove it and then check again
    protected $fillable = ['name', 'display_name', 'description'];
}
