<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GrahamCampbell\Markdown\Facades\Markdown;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'bio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function companies() {
        return $this->hasMany(Company::class, 'user_id');
    }

/*    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }*/

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) $this->attributes['password'] = bcrypt($value);
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getBioHtmlAttribute($value) {
        // escape is e
        return $this->bio ? Markdown::convertToHtml(e($this->bio)) : null;
    }

    public function gravatar() {
        $email = $this->email;
        $default = "https://cdn1.iconfinder.com/data/icons/business-users/512/circle-512.png";//asset("img/user.png");
        $size = 100;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
    }

    public function identities() {
       return $this->hasMany('App\SocialIdentity');
    }
}
