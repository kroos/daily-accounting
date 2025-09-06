<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__.'/../routes/web.php',
		api: __DIR__.'/../routes/api.php',
		commands: __DIR__.'/../routes/console.php',
		health: '/up',
	)
	->withMiddleware(function (Middleware $middleware) {
		// this is important for auth:sanctum
		$middleware->statefulApi();

		// Register global or route middleware here
		$middleware->alias([
			'transOwner' => App\Http\Middleware\Authorize\RedirectIfNotOwnerTransaction::class,
			'cateOwner' => App\Http\Middleware\Authorize\RedirectIfNotOwnerCategory::class,
		]);


	})
	->withExceptions(function (Exceptions $exceptions) {
		//
	})->create();
