<?php
namespace App\Http\Controllers;

// for controller output
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// models
use App\Models\Currency;

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

class CurrencyAjaxController extends Controller
{
	public function listcurrencies(Request $request): JsonResponse
	{
		// dd($request->all());
		// Fetch subcategories with optional search
		$values = Currency::when($request->search, function (Builder $query) use ($request) {
								$query->where('country', 'LIKE', '%' . $request->search . '%')
								->orWhere('currency_name', 'LIKE', '%' . $request->search . '%')
								->orWhere('currency_code', 'LIKE', '%' . $request->search . '%');
							})
							->orderBy('country')
							// ->ddrawsql();
							->get();
		return response()->json($values);
	}
}
