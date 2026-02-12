const { route, url,	old } = window.data;
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


// variables
let incomeChart = $('#incomeChart');
let expenseChart = $('#expenseChart');
let totalChart = $('#totalChart');

// Define consistent colors
const incomeColor = '#36A2EB';  // Blue
const expenseColor = '#FF6384'; // Red
let chartInstances = {}; // Declare globally

$.fn.dataTable.moment( 'D MMM YYYY' );
$('#transactionTable').DataTable({
	...config.datatable,
	'columnDefs': [
		{ type: 'date', 'targets': [0] },
	],
	'order': [
	[ 0, 'desc' ],
	[1, 'desc']   // then by type (descending)
	],
	ajax: {
		url: route.ajaxreports,
		type: 'POST',
		data: function(da){
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
		data: null,
		title: 'Amount',
		render: function (data, type, row) {
			console.log(row);
			// Convert to numeric safely (remove commas, RM, etc.)
			let numeric = parseFloat(String(row.amount).replace(/,/g, '').replace(/[^\d.-]/g, ''));

			if (isNaN(numeric)) numeric = 0;

			if (type === 'sort' || type === 'type' || type === 'filter') {
				return numeric;
			}

			// Format with thousands separators and 2 decimals
			return row.belongstouser.belongstocurrency.currency_code + ' ' + numeric.toLocaleString('en-MY', {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2
			});
		}
	},
	{ data: 'description' },
	{
		data: 'id',
		render: function(data){
			return `
			<div class="btn-group btn-group-sm" role="group">
				<a href="${url.transactions}/${data}" class="btn btn-sm btn-outline-info "><i class="fa-regular fa-file-pdf"></i></a>
				<a href="${url.transactions}/${data}/edit" class="btn btn-sm btn-outline-info "><i class="fa-solid fa-pen-to-square"></i></a>
				<a class="btn btn-sm btn-outline-danger delete" data-id="${data}"><i class="fa-solid fa-trash-can"></i></a>
			</div>
			`
		}
	}
	],
	initComplete: function(settings, response) {
		console.log(response);
		$(document).on('click', '.delete', function(e){
			var ackID = $(this).data('id');
			var ackTable = $(this).data('table');
			SwalDelete(ackID, ackTable);
			e.preventDefault();
		});

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



function SwalDelete(ackID, ackTable){
	swal.fire({
		...config.swal,
		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: `${url.transactionsdestroy}/${ackID}`,
					type: 'DELETE',
					dataType: 'json',
					data: {
						id: ackID,
					},
				})
				.done(function(response){
					swal.fire('Accept', response.message, response.status)
					.then(function(){
						updateTable();
					});
				})
				.fail(function(){
					swal.fire('Oops...', 'Something went wrong with ajax!', 'error');
				})
			});
		},
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal.fire('Cancel Action', '', 'info')
		}
	});
}
