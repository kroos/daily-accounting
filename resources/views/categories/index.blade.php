@extends('layouts.app')

@section('content')
<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">
	<div class="col-sm-8 d-flex justify-content-end">
		<a href="{{ route('categories.create') }}" class="btn btn sm btn-primary">Add Category</a>
	</div>
	<div class="col-sm-8 m-0">
		<table id="categories" class="table table-hover">
			<thead>
				<tr>
					<th>Category</th>
					<th>Type</th>
					<th>Color</th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script> -->
@endsection

@section('js')
////////////////////////////////////////////////////////////////////////////////////////////
// table
$('#categories').DataTable({
	'lengthMenu': [ [30, 60, 100, -1], [30, 60, 100, 'All'] ],
	// 'columnDefs': [
	// 	{ type: 'date', 'targets': [4] },
	// ],
	'order': [[ 1, 'desc' ]],
	'responsive': true,
	'autoWidth': false,
	// 'fixedHeader': true,
	'dom': 'Bfrtip',
	ajax: {
		url: '{{ route('ajax.listcategories') }}',
		type: 'GET',
		data: function(da){
				da._token = '{!! csrf_token() !!}';
				da.fromDate = $('#fromDate').val();
				da.toDate = $('#toDate').val();
		},
		dataSrc: 'table',
	},
	'columns': [
		{
			data: 'category'
		},
		{
			data: 'type',
			render: function(data) {
				return data.charAt(0).toUpperCase() + data.slice(1); // Capitalize the first letter
			}
		},
		{
			data: 'color',
			render: function(data){
				return `<div style="background-color: ${data}; width: 25px; height: 25px;"></div>`
			}
		},
		{
			data: 'id',
			render: function(data){
				return `
					<div class="m-0">
						<a href="categories/${data}/edit" class=""><i class="fa-solid fa-pen-to-square"></i></a>
					</div>
					`;
			}
		}
	],
	initComplete: function(settings, response) {
		// console.log(response); // This runs after successful loading
	}
});

////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////
@endsection
