@extends('layouts.app')

@section('content')
<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">

	<form action="{{ route('transactions.store') }}" method="POST" id="form" class="" enctype="multipart/form-data">
		@csrf

		<div class="card">
			<div class="card-header">
				<h3 class="my-auto">New Transactions </h3>

			</div>
			<div class="card-body">
				@include('transactions._form')
			</div>
			<div class="card-footer d-flex justify-content-end">
				<button type="submit" class="my-auto btn btn-sm btn-outline-primary me-1">
					<i class="fa-regular fa-floppy-disk"></i> Submit
				</button>
				<a href="{{ route('transactions.index') }}" class="my-auto btn btn-sm btn-outline-secondary me-1">
					<i class="fa-solid fa-delete-left"></i> Cancel
				</a>
			</div>
		</div>



	</form>

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
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endsection

@section('js')
@include('transactions._js')
@endsection
