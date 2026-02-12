@extends('layouts.app')

@section('content')
<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">

	<form action="{{ route('categories.update', $category->id) }}" method="POST" id="form" class="" enctype="multipart/form-data">
		@method('PATCH')
		@csrf
		<div class="card">
			<div class="card-header d-flex justify-content-between">
				<h3 class="my-auto">Edit Categories </h3>

			</div>
			<div class="card-body">
				@include('categories._form')
			</div>
			<div class="card-footer d-flex justify-content-end">
				<button type="submit" class="my-auto btn btn-sm btn-outline-primary me-1">
					<i class="fa-regular fa-floppy-disk"></i> Submit
				</button>
				<a href="{{ route('categories.index') }}" class="my-auto btn btn-sm btn-outline-secondary me-1">
					<i class="fa-solid fa-delete-left"></i> Cancel
				</a>
			</div>
		</div>
	</form>

</div>
@endsection

@section('js')
@include('categories._js')
@endsection
