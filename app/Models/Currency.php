<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use App\Models\Model;

// db relation class to load
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\Relations\HasOneThrough;
// use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\HasManyThrough;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// helper
use Illuminate\Support\Str;

class Currency extends Model
{
	use SoftDeletes; // Enable SoftDeletes
	protected $table = 'countries';

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// change value attribute
	public function setCountryAttribute($value)
	{
		$this->attributes['country'] = ucwords(Str::lower($value));
	}

	public function setCurrencyNameAttribute($value)
	{
		$this->attributes['currency_name'] = ucwords(Str::lower($value));
	}

	public function setCurrencyCodeAttribute($value)
	{
		$this->attributes['currency_code'] = Str::upper(Str::lower($value));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// db relation
	public function hasmanyuser(): HasMany
	{
		return $this->HasMany(\App\Models\User::class, 'currency_id');
	}
}
