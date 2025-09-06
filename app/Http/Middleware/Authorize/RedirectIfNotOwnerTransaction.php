<?php

namespace App\Http\Middleware\Authorize;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotOwnerTransaction
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		// dd($request->route()->transaction->user_id);
		if($request->user()->isTransactionOwner($request->route()->transaction->user_id)) {
			return $next($request);
		}
		// return redirect()->back();
		return abort(401);
	}
}
