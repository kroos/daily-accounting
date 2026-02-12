@extends('layouts.app')

@section('content')
<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">

	<div class="card">
		<div class="card-header d-flex justify-content-between">
			<h3 class="my-auto">Category List </h3>
			<a href="{{ route('categories.create') }}" class="my-auto btn btn-sm btn-outline-primary">
			<i class="fa-solid fa-arrow-up-right-from-square"></i> New Category </a>
		</div>
		<div class="card-body">
			<table id="categories" class="table table-hover"></table>
		</div>
		<div class="card-footer d-flex justify-content-end">
		</div>
	</div>

</div>
@endsection

@section('js')
window.data = {
	route:{
		listcategories: '{{ route('ajax.listcategories') }}',
	},
	url:{
		categories: '{{ url('categories') }}',
		categoriesdestroy: '{{ url('api/ajax/categories/destroy') }}',
	},
	old:{},
	user_id: {{ \Auth::user()->user_id }},
};

@endsection
