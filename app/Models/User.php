<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


// db relation class to load
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\Relations\HasOneThrough;
// use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// helper
use Illuminate\Support\Str;

class User extends Authenticatable
{
	/** @use HasFactory<\Database\Factories\UserFactory> */
	use HasFactory, Notifiable, SoftDeletes;

	// protected $connection = 'mysql';
	protected $table = 'users';
	protected $dates = ['deleted_at'];

	protected $guarded = [];

	 /**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// change value attribute
	public function setNameAttribute($value)
	{
		$this->attributes['name'] = ucwords(Str::lower($value));
	}

	public function setEmailAttribute($value)
	{
		$this->attributes['email'] = Str::lower($value);
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// db relation hasMany/hasOne
	public function hasmanylogin(): HasMany
	{
		return $this->hasMany(\App\Models\Login::class, 'user_id');
	}

	public function hasmanytransaction(): HasMany
	{
		return $this->hasMany(\App\Models\Transaction::class, 'user_id');
	}

	public function hasmanycategory(): HasMany
	{
		return $this->hasMany(\App\Models\Category::class, 'user_id');
	}

	public function belongstocurrency(): BelongsTo
	{
		return $this->BelongsTo(\App\Models\Currency::class, 'currency_id');
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////

}
