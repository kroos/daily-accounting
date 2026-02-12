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

window.data = {
	route: {
		ajaxreports: '{{ route('ajax.reports') }}',
	},
	url: {
		transactions: '{{ url('transactions') }}',
		transactionsdestroy: '{{ url('api/ajax/transactions/destroy') }}',
	},
	old: {},
};
@endsection
