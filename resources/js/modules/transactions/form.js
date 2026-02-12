const { route, url,	old } = window.data;

// clear select2 when click on radio button
$('input[name="type"]').click(function (){
	$('#category').val('').trigger('change')
});

$('#category').select2({
	...config.select2,
	ajax: {
		url: route.getCategories,
		type: 'POST',
		dataType: 'json',
		delay: 250,
		data: function (params) {
			return {
				type: $('[name="type"]:checked').val(),
				search: params.term,
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
if(old.category_id){
	$.ajax({
		url: route.getCategories,
		type: 'POST',
		dataType: 'json',
		delay: 250,
		data: {
			// type: $('[name="type"]:checked').val(),
			id: old.category_id,
		},
		success: function(resp){
			console.log(resp[0]);
			var newOptionCategory = new Option(
				resp[0].category,
				resp[0].id,
				true,
				true
			);
			// Add the color as a data attribute
			$(newOptionCategory).attr('data-color', resp[0].color);

			// Append and trigger
			$('#category').append(newOptionCategory).trigger('change');

		},
	});
}

$("#date").jqueryuiDatepicker({
	dateFormat: 'yy-mm-dd',
});


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

// $('#form1').submit(function (e) {
// 	e.preventDefault();
// 	let formData = new FormData(this);
//
// 	$.ajax({
// 		url: "route('transactions.store')",
// 		type: "POST",
// 		data: formData,
// 		processData: false,
// 		contentType: false,
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
