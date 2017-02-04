<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function submissions()
	{
		return $this->hasMany('App\Submission');
	}

	public function team()
	{
		return $this->hasOne('App\Team', 'owner_id');
	}

	public function setPasswordAttribute($password)
	{
		if (!empty($password))
		{
			$this->attributes['password'] = bcrypt($password);
		}
	}
}
