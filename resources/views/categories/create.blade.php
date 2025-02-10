@extends('layouts.app')

@section('content')
<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">
	<div class="card">
		<div class="card-header">
			<h4>New Category</h4>
		</div>
		<div class="card-body">
			<form action="{{ route('categories.store') }}" method="POST" id="form" class="" enctype="multipart/form-data">
				@csrf
				<div class="row">

					<div class="col-md-6 @error('category') has-error @enderror">
						<label for="cat" class="col-form-label">Category</label>
						<input type="text" name="category" value="{{ old('category') }}" id="cat" class="form-control form-control-sm @error('category') is-invalid @enderror" placeholder="Category">
						@error('category')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 @error('type') has-error @enderror">
						<label for="tp" class="col-form-label">Type</label>
						<select id="tp" name="type" class="form-select form-select-sm @error('type') is-invalid @enderror" placeholder="Please choose">
							<option value="">Please choose</option>
							<option value="income" selected="{{ old('type') }}">Income</option>
							<option value="expense" selected="{{ old('type') }}">Expense</option>
						</select>
						@error('type')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-md-6 @error('color') has-error @enderror">
						<label for="clr" class="col-form-label">Color</label>
						<input type="text" name="color" value="{{ old('color') }}" id="clr" class="form-control form-control-sm @error('color') is-invalid @enderror" placeholder="Color">
						@error('color')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="mt-3">
					<button type="submit" class="btn btn-success">Save Category</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('js')
////////////////////////////////////////////////////////////////////////////////////////////
$('#tp').select2({
	theme: 'bootstrap-5',
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

////////////////////////////////////////////////////////////////////////////////////////////
$('#clr').minicolors();

////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
@endsection
