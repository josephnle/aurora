<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'file',
		'orig_filename',
		'award_id',
		'user_id',
		'team_id'
	];

	protected static function boot() {
		parent::boot();

		static::creating(function ($model)
		{
			if (Auth::id()) {
				$model->user_id = Auth::id();
			}
		});
	}

	public function award()
	{
		return $this->belongsTo('App\Award');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function team()
	{
		return $this->belongsTo('App\Team');
	}
}
