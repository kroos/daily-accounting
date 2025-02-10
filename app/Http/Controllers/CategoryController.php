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

class CategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(): View
	{
		return view('categories.index');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
		return view('categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
				'type' => 'required|in:income,expense',
				'category' => 'required',
				'color' => ['required', 'regex:/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/'],
			], [
				'type' => 'Please choose :attribute',
				'category' => 'Please choose :attribute',
				'color' => 'Please choose :attribute',
				'color.regex' => 'Invalid color format. Please use a valid hex code (e.g., #ff0000).',
			], [
				'type' => 'Type',
				'category' => 'Category',
				'color' => 'Color',
		]);

		// Store transaction
		Category::create([
			'type' => $request->type,
			'category' => $request->category,
			'color' => $request->color,
		]);
		return redirect()->route('categories.create')->with('success', 'Category saved successfully!');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Category $category): View
	{
		return view('categories.show', ['category' => $category]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Category $category): View
	{
		return view('categories.edit', ['category' => $category]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Category $category): RedirectResponse
	{
		$request->validate([
				'type' => 'required|in:income,expense',
				'category' => 'required',
				'color' => ['required', 'regex:/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/'],
			], [
				'type' => 'Please choose :attribute',
				'category' => 'Please choose :attribute',
				'color' => 'Please choose :attribute',
				'color.regex' => 'Invalid color format. Please use a valid hex code (e.g., #ff0000).',
			], [
				'type' => 'Type',
				'category' => 'Category',
				'color' => 'Color',
		]);

		// Store transaction
		$category->update([
			'type' => $request->type,
			'category' => $request->category,
			'color' => $request->color,
		]);
		return redirect()->route('categories.index')->with('success', 'Category update successfully!');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Category $category): RedirectResponse
	{
		//
	}
}
