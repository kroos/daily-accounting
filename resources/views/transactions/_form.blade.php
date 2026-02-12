<div class="row">
	<div class="col-md-6 @error('type') has-error @enderror">
		<label for="type" class="col-form-label">Transaction Type</label>
		<!-- <br/> -->
		<div class="@error('type') is-invalid @enderror">
			<div class="form-check form-check-inline">
				<input class="form-check-input btn-check btn-sm @error('type') is-invalid @enderror" type="radio" name="type" id="inlineRadio1" value="income" @if(@$transaction->type == 'income') checked @endif>
				<label class="form-check-label btn btn-sm" for="inlineRadio1">Income</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input btn-check btn-sm @error('type') is-invalid @enderror" type="radio" name="type" id="inlineRadio2" value="expense" @if(@$transaction->type == 'expense') checked @endif>
				<label class="form-check-label btn btn-sm" for="inlineRadio2">Expense</label>
			</div>
		</div>
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

<div class="row mt-3">
	<div class="col-md-6 @error('date') has-error @enderror">
		<label for="date" class="col-form-label">Date</label>
		<input type="text" name="date" value="{{ old('date', @$transaction->date) }}" id="date" class="form-control form-control-sm @error('date') is-invalid @enderror" placeholder="Date">
		@error('date')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>

	<div class="col-md-6 @error('amount') has-error @enderror">
		<label for="amount" class="col-form-label">Amount</label>
		<input type="number" name="amount" value="{{ old('amount', @$transaction->amount) }}" id="amount" class="form-control form-control-sm @error('amount') is-invalid @enderror" min="0" step="any" placeholder="Amount">
		@error('amount')
		<div class="invalid-feedback">{{ $message }}</div>
		@enderror
	</div>

</div>

<div class="row mt-3 @error('description') has-error @enderror">
	<div class="col-md-12">
		<label for="description" class="col-form-label">Description (Optional)</label>
		<textarea id="description" name="description" class="form-control form-control-sm @error('description') is-invalid @enderror" placeholder="Description">{{ old('description', @$transaction->description) }}</textarea>
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

		<input type="text" id="barcode" name="barcode" value="{{ old('barcode', @$transaction->barcode) }}" class="form-control form-control-sm mt-2 @error('barcode') is-invalid @enderror" placeholder="Scanned barcode">
	</div>

</div>
