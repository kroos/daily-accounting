@extends('layouts.app')

@section('content')
	<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">


		<div class="card">
			<div class="card-header">
				<h4>New Transaction</h4>
			</div>
			<div class="card-body">
				<form action="{{ route('transactions.store') }}" method="POST" id="form" class="" enctype="multipart/form-data">
					@csrf
					<div class="row">

						<div class="col-md-6 @error('type') has-error @enderror">
							<label for="type" class="col-form-label">Transaction Type</label>
							<select id="type" name="type" class="form-select form-select-sm @error('type') is-invalid @enderror" placeholder="Please choose">
								<option value="">Please choose</option>
								<option value="income">Income</option>
								<option value="expense">Expense</option>
							</select>
							@error('type')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 @error('category_id') has-error @enderror">
							<label for="category" class="col-form-label">Category</label>
							<select id="category" name="category_id" class="form-select form-select-sm @error('category_id') is-invalid @enderror" placeholder="Please choose"></select>
							@error('category_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="row mt-3 @error('date') has-error @enderror">
						<div class="col-md-6">
							<label for="date" class="col-form-label">Date</label>
							<input type="text" name="date" id="date" class="form-control form-control-sm @error('date') is-invalid @enderror" placeholder="Date">
							@error('date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 @error('amount') has-error @enderror">
							<label for="amount" class="col-form-label">Amount</label>
							<input type="number" name="amount" id="amount" class="form-control form-control-sm @error('amount') is-invalid @enderror" min="0" step="any" placeholder="Amount">
							@error('amount')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="row mt-3 @error('description') has-error @enderror">
						<div class="col-md-12">
							<label for="description" class="col-form-label">Description (Optional)</label>
							<textarea id="description" name="description" class="form-control form-control-sm @error('description') is-invalid @enderror" placeholder="Description"></textarea>
							@error('description')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="row mt-3 @error('receipt') has-error @enderror">
						<div class="col-md-6">
							<label for="receipt" class="col-form-label">Upload Receipt</label>
							<input type="file" name="receipt" id="receipt" class="form-control form-control-sm @error('receipt') is-invalid @enderror" placeholder="Upload file">
							@error('receipt')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6">
							<label for="scanBarcode" class="col-form-label">Scan Barcode</label>

							<!-- Button trigger modal -->
							<button type="button" id="scanBarcode" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#scanbarcde">Scan</button>

							<input type="text" id="barcode" name="barcode" class="form-control form-control-sm mt-2 @error('barcode') is-invalid @enderror" placeholder="Scanned barcode">
						</div>
					</div>

					<div class="mt-3">
						<button type="submit" class="btn btn-success">Save Transaction</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="scanbarcde" tabindex="-1" aria-labelledby="scanbrcd" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="scanbrcd">Scan Barcode</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<video id="scannerCamera" width="100%" height="300"></video>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
					</div>
				</div>
			</div>
		</div>

	</div>
	<script src=" https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js "></script>
@endsection

@section('js')
////////////////////////////////////////////////////////////////////////////////////////////
$('#type').select2({
	theme: 'bootstrap-5',
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
});

$('#category').select2({
	theme: 'bootstrap-5',
	placeholder: 'Please choose',
	allowClear: true,
	closeOnSelect: true,
	width: '100%',
	ajax: {
		url: '{{ route('ajax.categories') }}',
		type: 'GET',
		dataType: 'json',
		delay: 250,											// Delay to reduce server requests
		data: function (params) {
			return {
				_token: '{!! csrf_token() !!}',
				search: params.term,				// Search query
			}
		},
		processResults: function (data) {
			return { results: data }; // Since backend returns a flat array, no need to transform
		}
	},
});

////////////////////////////////////////////////////////////////////////////////////////////
$("#date").jqueryuiDatepicker({
	dateFormat: 'yy-mm-dd',
});

////////////////////////////////////////////////////////////////////////////////////////////
$('#scanBarcode').click(function () {
	Quagga.onDetected(function (data) {
		$('#barcode').val(data.codeResult.code);
		Quagga.stop();
		$('#scannerModal').modal('hide');
	});


	Quagga.init({
		inputStream: {
			type: "LiveStream",
			target: document.querySelector("#scannerCamera"),
			constraints: {
				facingMode: "environment" // Use rear camera if available
			}
		},
		decoder: {
			readers: ["ean_reader", "ean_8_reader", "code_128_reader"]
		}
	}, function (err) {
		if (!err) {
			Quagga.start();
		} else {
			console.error(err);
		}
	});

	Quagga.onDetected(function (data) {
		$('#barcode').val(data.codeResult.code);
		Quagga.stop();
		$('#scannerModal').modal('hide');
	});
});

////////////////////////////////////////////////////////////////////////////////////////////
// $('#form1').submit(function (e) {
// 	e.preventDefault();
// 	let formData = new FormData(this);
//
// 	$.ajax({
// 		url: "{{ route('transactions.store') }}",
// 		type: "POST",
// 		data: formData,
// 		processData: false,
// 		contentType: false,
// 		headers: {
// 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// 		},
// 		success: function (response) {
// 			swal.fire('Transaction Save', response.message, 'success');
// 			$('#transactionForm')[0].reset();
// 			$('#category').val(null).trigger('change'); // Reset Select2
// 			$('#type').val(null).trigger('change'); // Reset Select2
// 		},
// 		error: function (xhr) {
// 			const res = xhr.responseJSON;
// 			// Extract the errors and concatenate them into a string
// 			const errorMessages = Object.values(res.errors)
// 					.flat() // Flatten the arrays
// 					.join('<br>'); // Join them with line breaks for better formatting
//
// 			// Display the errors using SweetAlert2
// 			swal.fire({
// 					title: 'Error',
// 					html: errorMessages, // Use `html` to render the line breaks
// 					icon: 'error'
// 			});
// 		}
// 	});
// });

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
@endsection
