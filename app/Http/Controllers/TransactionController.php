<?php

namespace App\Http\Controllers;


// for controller output
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// models
use App\Models\Transaction;

// load db facade
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;

// load batch and queue
// use Illuminate\Bus\Batch;
// use Illuminate\Support\Facades\Bus;

// load helper
// use Illuminate\Support\Arr;
// use Illuminate\Support\Str;
// use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\Storage;

// load pdf
use Barryvdh\DomPDF\Facade\Pdf;

// load Carbon library
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

// use Session;
// use Throwable;
// use Exception;
// use Log;

class TransactionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(): View
	{
		$fromDate = Carbon::now()->startOfMonth()->toDateString();
		$toDate = Carbon::now()->endOfMonth()->toDateString();

		$transactions = Transaction::with('belongstocategory')
			->where('user_id', \Auth::user()->belongstouser->id)
			->whereBetween('date', [$fromDate, $toDate])
			->orderBy('date', 'desc')
			->get();
		return view('transactions.index', ['transactions' => $transactions, 'fromDate' => $fromDate, 'toDate' => $toDate]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
		return view('transactions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
				'type' => 'required|in:income,expense',
				'category_id' => 'required|exists:categories,id',
				'date' => 'required|date',
				'amount' => 'required|numeric|min:0.01',
				'description' => 'nullable|string|max:255',
				'barcode' => 'nullable|string|max:255',
				'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Limit to 2MB
			], [
				'type' => 'Please choose :attribute',
				'category_id' => 'Please choose :attribute',
				'date' => 'Please insert :attribute',
				'amount' => 'Please insert :attribute',
				'description' => 'Please insert :attribute',
				'barcode' => 'Please scan :attribute',
				'receipt' => 'Please insert :attribute', // Limit to 2MB
			], [
				'type' => 'Type',
				'category_id' => 'Category',
				'date' => 'Date',
				'amount' => 'Amount',
				'description' => 'Description',
				'barcode' => 'Barcode',
				'receipt' => 'Receipt', // Limit to 2MB
		]);

		// Store transaction
		$transaction = Transaction::create([
			'user_id' => \Auth::user()->belongstouser->id,
			'type' => $request->type,
			'category_id' => $request->category_id,
			'date' => $request->date,
			'amount' => $request->amount,
			'description' => $request->description,
		]);

			// Handle receipt upload
		if ($request->hasFile('receipt')) {
			$path = $request->file('receipt')->store('receipts', 'public');
			$transaction->hasmanyupload()->create(['file_path' => $path, 'file_type' => $request->file('receipt')->extension()]);
		}
		return redirect()->route('transactions.create')->with('success', 'Transaction saved successfully!');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Transaction $transaction): View
	{
		return view('transactions.show', ['transaction' => $transaction]);
		// Pdf::loadView('email.show', ['email' => $r])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-ER-'.Carbon::parse($r->created_at)->format('ym').str_pad( $r->id, 3, "0", STR_PAD_LEFT).'.pdf');
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Transaction $transaction): View
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Transaction $transaction): RedirectResponse
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Transaction $transaction): JsonResponse
	{
		$transaction->delete();
		return response()->json(['message' => 'Transaction deleted', 'status' => 'info']);
	}
}
