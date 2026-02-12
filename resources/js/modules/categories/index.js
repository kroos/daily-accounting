const { route, url, old, user_id } = window.data;
// table
var table = $('#categories').DataTable({
	...config.datatable,
	'order': [[ 1, 'desc' ]],
	// dom: 'Bfrtip',
	ajax: {
		url: route.listcategories,
		type: 'GET',
		data: function(da){
				da.fromDate = $('#fromDate').val();
				da.toDate = $('#toDate').val();
		},
		dataSrc: 'table',
	},
	'columns': [
		{
			data: 'category',
			title: 'Category',
		},
		{
			data: 'type',
			title: 'Type',
			render: function(data) {
				return data.charAt(0).toUpperCase() + data.slice(1); // Capitalize the first letter
			}
		},
		{
			data: 'color',
			title: 'Color',
			render: function(data){
				return `<div style="background-color: ${data}; width: 25px; height: 25px;"></div>`
			}
		},
		{
			data: null, // Use null to access the whole row data
			title: '#',
			orderable: false,
			searchable: false,
			render: function(data){
				if(data.user_id == user_id){
					return `
						<div class="btn-group btn-group-sm" role="group">
							<a href="${url.categories}/${data.id}/edit" class="btn btn-sm btn-outline-info">
								<i class="fa-solid fa-pen-to-square"></i>
							</a>
							<a class="btn btn-sm btn-outline-danger delete" data-id="${data.id}"><i class="fa-solid fa-trash-can"></i></a>
						</div>
						`;
				}
				return ''; // Return an empty string if user_id is null
			}
		}
	],
	initComplete: function(settings, response) {
		// console.log(response); // This runs after successful loading
		$(document).on('click', '.delete', function(e){
			var ackID = $(this).data('id');
			var ackTable = $(this).data('table');
			SwalDelete(ackID, ackTable);
			e.preventDefault();
		});

	}
});

function SwalDelete(ackID, ackTable){
	swal.fire({
		...config.swal,
		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: `${url.categoriesdestroy}/${ackID}`,
					type: 'DELETE',
					dataType: 'json',
					data: {
						id: ackID,
					},
				})
				.done(function(response){
					swal.fire('Accept', response.message, response.status)
					.then(function(){
						table.ajax.reload();
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
