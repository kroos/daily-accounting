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
						<!-- <br/> -->
						<div class="@error('type') is-invalid @enderror">
							<div class="form-check form-check-inline">
								<input class="form-check-input btn-check btn-sm @error('type') is-invalid @enderror" type="radio" name="type" id="inlineRadio1" value="income" @if(old('type') == 'income') checked @endif>
								<label class="form-check-label btn btn-sm" for="inlineRadio1">Income</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input btn-check btn-sm @error('type') is-invalid @enderror" type="radio" name="type" id="inlineRadio2" value="expense" @if(old('type') == 'expense') checked @endif>
								<label class="form-check-label btn btn-sm" for="inlineRadio2">Expense</label>
							</div>
						</div>
						@error('type')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 @error('category_id') has-error @enderror">
						<label for="category" class="col-form-label">Category</label>
						<select id="category" name="category_id" value="{{ old('category_id' )}}" class="form-select form-select-sm @error('category_id') is-invalid @enderror" placeholder="Please choose"></select>
						@error('category_id')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-md-6 @error('date') has-error @enderror">
						<label for="date" class="col-form-label">Date</label>
						<input type="text" name="date" value="{{ old('date') }}" id="date" class="form-control form-control-sm @error('date') is-invalid @enderror" placeholder="Date">
						@error('date')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 @error('amount') has-error @enderror">
						<label for="amount" class="col-form-label">Amount</label>
						<input type="number" name="amount" value="{{ old('amount') }}" id="amount" class="form-control form-control-sm @error('amount') is-invalid @enderror" min="0" step="any" placeholder="Amount">
						@error('amount')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="row mt-3 @error('description') has-error @enderror">
					<div class="col-md-12">
						<label for="description" class="col-form-label">Description (Optional)</label>
						<textarea id="description" name="description" class="form-control form-control-sm @error('description') is-invalid @enderror" placeholder="Description">{{ old('description') }}</textarea>
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

				<div class="col-sm-4 mx-auto my-2">
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
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endsection

@section('js')
$.get('/sanctum/csrf-cookie').done(function () {
	////////////////////////////////////////////////////////////////////////////////////////////
	// clear select2 when click on radio button
	$('input[name="type"]').click(function (){
		$('#category').val('').trigger('change')
	});

	////////////////////////////////////////////////////////////////////////////////////////////
	$('#category').select2({
		theme: 'bootstrap-5',
		placeholder: 'Please choose',
		allowClear: true,
		closeOnSelect: true,
		width: '100%',
		ajax: {
			url: '{{ route('ajax.getCategories') }}',
			type: 'POST',
			dataType: 'json',
			delay: 250,											// Delay to reduce server requests
			data: function (params) {
				return {
					_token: '{!! csrf_token() !!}',
					type: $('input[name="type"]:checked').val(),
					search: params.term,				// Search query
				}
			},
			processResults: function (data) {
				return {
					results: data.map(function (item) {
						return {
							id: item.id,         // Value
							text: item.category,  // Displayed text
							color: item.color // keep color for display
						};
					})
				};
			}
		},
		templateResult: function (data) {
			if (!data.id) return data.text;

			let $colorBox = $('<span>').css({
				display: 'inline-block',
				width: '12px',
				height: '12px',
				'margin-right': '6px',
				'vertical-align': 'middle',
				'background-color': data.color || '#ccc',
				'border-radius': '2px'
			});

			return $('<span>').append($colorBox).append(document.createTextNode(data.text));
		},
		templateSelection: function (data) {
			if (!data.id) return data.text || '';

				// ✅ Ensure we always have a color
			let color = data.color || (data.element ? $(data.element).data('color') : '#ccc');

			let $colorBox = $('<span>').css({
				display: 'inline-block',
				width: '12px',
				height: '12px',
				'margin-right': '6px',
				'vertical-align': 'middle',
				'background-color': color,
				'border-radius': '2px'
			});

			return $('<span>').append($colorBox).append(document.createTextNode(data.text));
		},
				// ✅ Store color as data-color attribute for persistence
		templateSelectionUpdate: function (data, container) {
			if (data.color) {
				$(container).attr('data-color', data.color);
			}
		}
	});
	@if(null !== old('category_id'))
		// var newOptionType = new Option('{!! \App\Models\Category::find(old('category_id'))->category !!}', '{{ old('category_id') }}', true, true);
		// $('#category').append(newOptionType).trigger('change');




		var newOptionCategory = new Option(
			'{!! \App\Models\Category::find(old('category_id'))->category !!}',
			'{{ old('category_id') }}',
			true,
			true
		);
		// Add the color as a data attribute
		$(newOptionCategory).attr('data-color', '{!! \App\Models\Category::find(old('category_id'))->category !!}');

		// Append and trigger
		$('#category').append(newOptionCategory).trigger('change');
	@endif

	////////////////////////////////////////////////////////////////////////////////////////////
	$("#date").jqueryuiDatepicker({
		dateFormat: 'yy-mm-dd',
	});

	////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////
	let scanner = new Html5Qrcode("scannerCamera");
	let isScanning = false;

	// Function to start scanning
	function startScanner() {
		if (!isScanning) {
			// Request camera access
			navigator.mediaDevices.getUserMedia({ video: true })

			if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
				alert("Your browser does not support camera access. Please use a modern browser like Chrome or Safari.");
			} else {
				navigator.mediaDevices.getUserMedia({ video: true })
				.then((stream) => {
					// Camera access granted ✅
					scanner.start(
					{ facingMode: "environment" }, // Use back camera
					{ fps: 10, qrbox: 250 },
					(decodedText) => {
						$("#barcode").val(decodedText); // Set barcode value
						$("#scanbarcde").modal("hide"); // Close modal
						stopScanner(); // Stop scanning
					},
					(errorMessage) => {
						console.warn("Scanning error:", errorMessage);
					}
					).then(() => {
						isScanning = true;
					}).catch((err) => {
						console.error("Scanner initialization failed:", err);
					});
				})
				.catch((err) => {
					// Camera permission denied ❌
					console.error("Camera permission error:", err);
					swal.fire('Error :', "Camera access is required for barcode scanning. Please enable it in your browser settings.", 'error');
				});
			}
		}
	}

	// Function to stop scanner
	function stopScanner() {
		if (isScanning) {
			scanner.stop().then(() => {
				isScanning = false;
			}).catch((err) => {
				console.error("Scanner stop error:", err);
			});
		}
	}

	// Start scanner when modal opens
	$("#scanbarcde").on("shown.bs.modal", function () {
		startScanner();
	});

	// Stop scanner when modal closes
	$("#scanbarcde").on("hidden.bs.modal", function () {
		stopScanner();
	});

	////////////////////////////////////////////////////////////////////////////////////////////
	// $('#scanBarcode').click(function () {
	// 	Quagga.onDetected(function (data) {
	// 		$('#barcode').val(data.codeResult.code);
	// 		Quagga.stop();
	// 		$('#scannerModal').modal('hide');
	// 	});
	// 	Quagga.init({
	// 		inputStream: {
	// 			type: "LiveStream",
	// 			target: document.querySelector("#scannerCamera"),
	// 			constraints: {
	// 				facingMode: "environment" // Use rear camera if available
	// 			}
	// 		},
	// 		decoder: {
	// 			readers: ["ean_reader", "ean_8_reader", "code_128_reader"]
	// 		}
	// 	}, function (err) {
	// 		if (err) {
	// 			console.error("Quagga initialization failed:", err);
	// 			return;
	// 		}
	// 		console.log("Quagga initialized successfully");
	// 		Quagga.start();
	// 	});
	// 	Quagga.onDetected(function (data) {
	// 		$('#barcode').val(data.codeResult.code);
	// 		Quagga.stop();
	// 		$('#scannerModal').modal('hide');
	// 	});
	// });

	////////////////////////////////////////////////////////////////////////////////////////////
	// scanbot demo
	// When initializing the SDK, we specify the path to the barcode scanner engine
	// $(document).ready(function () {
	// 	async function initializeSDK() {
	// 		const sdk = await window.ScanbotSDK.initialize({
	// 			engine: "{{ asset('js/scanbot-web-sdk/bundle/bin/barcode-scanner/') }}/"
	// 		});
	// 		$("#start-scanning").click(async function () {
	// 			const config = new window.ScanbotSDK.UI.Config.BarcodeScannerConfiguration();
	// 			const scanResult = await window.ScanbotSDK.UI.createBarcodeScanner(config);
	// 			if (scanResult?.items?.length > 0) {
	// 				$("#result").text(
	// 				`Barcode type: ${scanResult.items[0].type} \n` +
	// 				`Barcode content: "${scanResult.items[0].text}" \n`
	// 				);
	// 			} else {
	// 				$("#result").text("Scanning aborted by the user");
	// 			}
	// 		});
	// 	}
	// 	initializeSDK();
	// });
	// const sdk = await ScanbotSDK.initialize({
	// 	engine: "{{ asset('js/scanbot-web-sdk/bundle/bin/barcode-scanner/') }}"
	// });
	// document.getElementById("start-scanning").addEventListener("click", async () => {
	// 	// We create a new default configuration for the barcode scanner
	// 	const config = new ScanbotSDK.UI.Config.BarcodeScannerConfiguration();
	// 	// We create a barcode scanner UI component
	// 	const scanResult = await ScanbotSDK.UI.createBarcodeScanner(config);
	// 	// Once the scanning is done, we display the result
	// 	if (scanResult?.items?.length > 0) {
	// 		document.getElementById("result").innerText =
	// 			`Barcode type: ${scanResult.items[0].type} \n` +
	// 			`Barcode content: "${scanResult.items[0].text}" \n`;
	// 	} else {
	// 		document.getElementById("result").innerText = "Scanning aborted by the user";
	// 	}
	// });
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
});
@endsection
