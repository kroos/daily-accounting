@extends('layouts.app')

@section('content')
<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center border border-primary-subtle rounded">

	<div class="card my-1">
		<div class="card-header">
			<h3 class="my-auto">Home </h3>
		</div>
		<div class="card-body d-flex flex-column justify-content-center">
			<p class="text-center">{{ config('app.name', 'Laravel') }}</p>
			<p class="text-center">
				<img src="{{ asset('images/logo.png') }}" alt="{!! config('app.name') !!}" title="{!! config('app.name') !!}" width="20%" class="mx-2 my-auto img-responsive img-rounded">
			</p>

		</div>
		<div class="card-footer">
		</div>
	</div>

</div>
@endsection

@section('js')
@endsection
