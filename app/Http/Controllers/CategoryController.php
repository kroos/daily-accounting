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
		//
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Category $category): View
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Category $category): View
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Category $category): RedirectResponse
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Category $category): RedirectResponse
	{
		//
	}
}
