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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
	use SoftDeletes;

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// db relation hasMany/hasOne
	public function hasmanyupload(): HasMany
	{
		return $this->HasMany(Upload::class);
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// db relation BelongsTo
	public function belongstouser(): BelongsTo
	{
		return $this->BelongsTo(User::class, 'user_id');
	}

	public function belongstocategory(): BelongsTo
	{
			return $this->BelongsTo(Category::class, 'category_id');
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////
}
