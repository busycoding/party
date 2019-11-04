<?php

namespace App;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
	// TODO: not even sure if fillable works here, remove it and then check again
    protected $fillable = ['name', 'display_name', 'description'];
}
