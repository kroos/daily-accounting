@extends('layouts.app')

@section('content')
	<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">

		<div class="card">
			<div class="card-header">
				<h4>Income & Expense Reports</h4>
			</div>
			<div class="card-body">
				<div class="row justify-content-evenly mb-5">
					<div class="col-3 my-3 @error('fromDate') has-error @enderror">
						<input type="text" name="fromDate" id="fromDate" class="form-control form-control-sm  @error('fromDate') has-error @enderror" value="{{ old('fromDate', $fromDate) }}" placeholder="From Date">
						@error('fromDate')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="col-3 my-3 @error('toDate') has-error @enderror">
						<input type="text" name="toDate" id="toDate" class="form-control form-control-sm  @error('toDate') has-error @enderror" value="{{ old('toDate', $toDate) }}" placeholder="To Date">
						@error('toDate')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="row my-2 justify-content-center">
					<div class="col-md-4 text-center">
						<h5>Income Breakdown</h5>
						<div style="width: 100% !important; min-height: 300px; position: relative;">
							<canvas id="incomeChart" style="width: 100% !important; height: auto !important;"></canvas>
						</div>
					</div>
					<div class="col-md-4 text-center">
						<h5>Expense Breakdown</h5>
						<div style="width: 100% !important; min-height: 300px; position: relative;">
							<canvas id="expenseChart" style="width: 100% !important; height: auto !important;"></canvas>
						</div>
					</div>
					<div class="col-md-4 text-center">
						<h5>Total Income vs Expenses</h5>
						<div style="width: 100% !important; min-height: 300px; position: relative;">
							<canvas id="totalChart" style="width: 100% !important; height: auto !important;"></canvas>
						</div>
					</div>
				</div>

				<table id="transactionTable" class="table my-3" style="width: 100% !important; table-layout: auto !important;">
					<thead class="table table hover">
						<tr>
							<th>Date</th>
							<th>Type</th>
							<th>Category</th>
							<th>Amount</th>
							<th>Description</th>
							<th></th>
						</tr>
					</thead>
			</table>

			</div>
		</div>

	</div>
@endsection

@section('js')
////////////////////////////////////////////////////////////////////////////////////////////
// date
$('#fromDate').jqueryuiDatepicker({
	dateFormat: 'yy-mm-dd',
}).on('change', function() {
	$('#toDate').datepicker('option', 'minDate', this.value);
	updateTable();
});

$('#toDate').jqueryuiDatepicker({
	dateFormat: 'yy-mm-dd',
}).on('change', function() {
	$('#fromDate').datepicker('option', 'maxDate', this.value);
	updateTable();
});

$.get('/sanctum/csrf-cookie').done(function () {
	////////////////////////////////////////////////////////////////////////////////////////////
	// variables
	let route = '{{ route('ajax.reports') }}';
	let incomeChart = $('#incomeChart');
	let expenseChart = $('#expenseChart');
	let totalChart = $('#totalChart');

	// Define consistent colors
	const incomeColor = '#36A2EB';  // Blue
	const expenseColor = '#FF6384'; // Red
	let chartInstances = {}; // Declare globally

	$('#transactionTable').DataTable({
		'lengthMenu': [ [30, 60, 100, -1], [30, 60, 100, 'All'] ],
		'columnDefs': [
			{ type: 'date', 'targets': [4] },
		],
		'order': [[ 0, 'desc' ]],
		'responsive': true,
		'autoWidth': true,
		// 'fixedHeader': true,
		// 'dom': 'Bfrtip',
		ajax: {
			url: route,
			type: 'POST',
			data: function(da){
					da._token = '{!! csrf_token() !!}';
					da.fromDate = $('#fromDate').val();
					da.toDate = $('#toDate').val();
			},
			dataSrc: 'table',
		},
		'columns': [
			{
				data: 'date',
				render: function(data) {
					return moment(data).format('D MMM YYYY');
				}
			},
			{
				data: 'type',
				render: function(data) {
					return data.charAt(0).toUpperCase() + data.slice(1); // Capitalize the first letter
				}
			},
			{ data: 'belongstocategory.category' },
			{
				data: 'amount',
				render: function(data) {
					return 'RM' + parseFloat(data).toFixed(2); // Format amount as decimal
				}
			},
			{ data: 'description' },
			{
				data: 'id',
				render: function(data){
					return `
						<div class="m-0">
							<a href="transactions/${data}" class=""><i class="fa-regular fa-file-pdf"></i></a>
							<a href="transactions/${data}/edit" class=""><i class="fa-solid fa-pen-to-square"></i></a>
							<a class="text-danger delete" data-id="${data}"><i class="fa-solid fa-trash-can"></i></a>
						</div>
						`
				}
			}
		],
		initComplete: function(settings, response) {
			// console.log(response); // This runs after successful loading
		}
	});

	$('#transactionTable').on('xhr.dt', function(e, settings, response) {
		console.log("Data Refreshed:");
		console.log(response); // `response` contains the latest response data
		if(response) {
			updateChart('incomeChart', 'Income Breakdown', response.incomeData, response.table);
			updateChart('expenseChart', 'Expense Breakdown', response.expenseData, response.table);
			updateTotalChart('totalChart', 'Total Income vs Expenses', response.totalIncome, response.totalExpense, incomeColor, expenseColor);
		}
	});

	function updateTable() {
		$('#transactionTable').DataTable().ajax.reload();
	}

	////////////////////////////////////////////////////////////////////////////////////////////
	// Update Chart

	function updateChart(canvasId, label, data, tableData) {
		const ctx = document.getElementById(canvasId);

		if (chartInstances[canvasId]) {
			chartInstances[canvasId].destroy();
		}

		// Get colors dynamically based on categories
		let colors = Object.keys(data).map(category => {
			let item = tableData.find(entry => entry.belongstocategory.category === category);
			return item ? item.belongstocategory.color : '#000000'; // Default to black if not found
		});

		chartInstances[canvasId] = new Chart(ctx, {
			type: 'pie',
			data: {
				// labels: Object.keys(data),
				datasets: [{
					data: Object.values(data),
					backgroundColor: colors,
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,

				// scales: {
				// 	y: {
				// 		stacked: true,
				// 		grid: {
				// 			display: true,
				// 			// color: "rgba(255,99,132,0.2)"
				// 		}
				// 	},
				// 	x: {
				// 		grid: {
				// 			display: false
				// 		}
				// 	}
				// }

				plugins: {
					title: {
						display: true,
						text: label
					}
				},

			}
		});
	}

	function updateTotalChart(canvasId, label, totalIncome, totalExpense, incomeColor, expenseColor) {
		const ctx = document.getElementById(canvasId);

		if (chartInstances[canvasId]) {
			chartInstances[canvasId].destroy();
		}

		let totalBalance = totalIncome-totalExpense;

		chartInstances[canvasId] = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: ['Total Income', 'Total Expenses'],
				datasets: [{
					data: [totalBalance, totalExpense],
					backgroundColor: [incomeColor, expenseColor] // Different colors for Income & Expense
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,

				// scales: {
				// 	y: {
				// 		stacked: true,
				// 		grid: {
				// 			display: true,
				// 			// color: "rgba(255,99,132,0.2)"
				// 		}
				// 	},
				// 	x: {
				// 		grid: {
				// 			display: false
				// 		}
				// 	}
				// }

				plugins: {
					title: {
						display: true,
						text: label
					}
				}
			}
		});
	}

	updateTable();

	////////////////////////////////////////////////////////////////////////////////////////////
	$(document).on('click', '.delete', function(e){
		var ackID = $(this).data('id');
		var ackTable = $(this).data('table');
		SwalDelete(ackID, ackTable);
		e.preventDefault();
	});

	function SwalDelete(ackID, ackTable){
		swal.fire({
			title: 'Delete Transaction',
			text: 'Are you sure to delete this transaction?',
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Cancel',
			confirmButtonText: 'Yes',
			showLoaderOnConfirm: true,

			preConfirm: function() {
				return new Promise(function(resolve) {
					$.ajax({
						url: '{{ url('transactions') }}' + '/' + ackID,
						type: 'DELETE',
						dataType: 'json',
						data: {
							id: ackID,
							_token : $('meta[name=csrf-token]').attr('content')
						},
					})
					.done(function(response){
						swal.fire('Accept', response.message, response.status)
						.then(function(){
							window.location.reload(true);
						});
					})
					.fail(function(){
						swal.fire('Oops...', 'Something went wrong with ajax!', 'error');
					})
				});
			},
			allowOutsideClick: false
		})
		.then((result) => {
			if (result.dismiss === swal.DismissReason.cancel) {
				swal.fire('Cancel Action', '', 'info')
			}
		});
	}
});
////////////////////////////////////////////////////////////////////////////////////////////
@endsection
