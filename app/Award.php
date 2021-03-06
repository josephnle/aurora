<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Award extends Model {

	use Sluggable, SluggableScopeHelpers;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'description',
		'open',
		'deadline',
		'user_id'
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'open',
		'deadline'
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

	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable()
	{
		return [
			'slug' => [
				'source' => 'name'
			]
		];
	}

	public function submissions()
	{
		return $this->hasMany('App\Submission');
	}

	public function setOpenAttribute($open)
	{
		$this->attributes['open'] = Carbon::parse($open);
	}

	public function setDeadlineAttribute($deadline)
	{
		$this->attributes['deadline'] = Carbon::parse($deadline);
	}

	public function isOpen()
	{
		return Carbon::now() >= $this->attributes['open'] && Carbon::now() < $this->attributes['deadline'];
	}

	public function isClosed()
	{
		return !$this->isOpen();
	}
}
