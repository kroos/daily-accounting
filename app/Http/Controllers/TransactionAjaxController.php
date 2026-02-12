<?php
namespace App\Http\Controllers;

// for controller output
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// models
use App\Models\Transaction;
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

class TransactionAjaxController extends Controller
{
	public function getTransactions(Request $request): JsonResponse
	{
		$request->validate([
			'fromDate' => 'required|date',
			'toDate' => 'required|date|after_or_equal:fromDate',
		]);

		$fromDate = $request->input('fromDate');
		$toDate = $request->input('toDate');

				// Get transactions in date range
		$transactions = Transaction::with(['belongstocategory', 'belongstouser.belongstocurrency'])
		->where('user_id', \Auth::user()->user_id)
		->whereBetween('date', [$fromDate, $toDate])
		->orderBy('date', 'desc')
		->get();

		// Group transactions by type
		$incomeData = $transactions->where('type', 'income')->groupBy('belongstocategory.category')->map->sum('amount');
		$expenseData = $transactions->where('type', 'expense')->groupBy('belongstocategory.category')->map->sum('amount');
		// dd($incomeData);

		// Calculate total income & total expenses
		$totalIncome = $incomeData->sum();
		$totalExpense = $expenseData->sum();

		return response()->json([
			'table' => $transactions,
			'incomeData' => $incomeData,
			'expenseData' => $expenseData,
			'totalIncome' => $totalIncome,
			'totalExpense' => $totalExpense,
		]);
	}
}
