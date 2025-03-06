<?php
namespace App\Http\Controllers;

// for controller output
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// models
use App\Models\Category;

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

// load validation


// load batch and queue
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

// load helper
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

// load Carbon library
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

use Session;
use Throwable;
use Exception;
use Log;

class CategoryAjaxController extends Controller
{
	public function getCategories(Request $request): JsonResponse
	{
		// dd($request->all());
		// Fetch subcategories with optional search
		$values = Category::where('user_id', \Auth::user()->belongstouser->id)
							->orWhereNull('user_id')
							->when($request->search, function ($query) use ($request) {
								$query->where('category', 'LIKE', '%' . $request->search . '%');
							})
							->when($request->type, function ($query) use ($request){
								$query->where('type', $request->type);
							})
							// ->ddrawsql();
							->pluck('category', 'id');
		// dd($values);

		// Convert to plain array format
		$formattedValues = $values->map(function ($name, $id) {
			return ['id' => $id, 'text' => $name];
		})->values(); // Ensure indexed array

		return response()->json($formattedValues);
	}

	public function listcategories(): JsonResponse
	{
		$categories = Category::where(function(Builder $query){
			$query->where('user_id', \Auth::user()->belongstouser->id)
			->orWhereNull('user_id');
		})
		->orderBy('type', 'desc')
		->get();
		return response()->json(['table' => $categories]);
	}
}
