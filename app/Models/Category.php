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

class Category extends Model
{
	use SoftDeletes; // Enable SoftDeletes

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// change value attribute
	public function setCategoryAttribute($value)
	{
		$this->attributes['category'] = ucwords(Str::lower($value));
	}

	public function setTypeAttribute($value)
	{
		$this->attributes['type'] = Str::lower($value);
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// db relation
	public function hasmanytransactions(): HasMany
	{
		return $this->hasMany(Transaction::class, 'category_id');
	}
}
