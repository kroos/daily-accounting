@extends('layouts.app')

@section('content')
<div class="col-sm-6 d-flex flex-column align-items-center justify-content-center">
	<h3>Profile</h3>


	<div class="card my-3">
		<div class="card-header">
			<h3 class="card-title">Update Profile Information</h3>
		</div>

		<div class="card-body">
			<div class="col-sm-12">@include('profile.partials.update-profile-information-form')</div>
		</div>
		<div class="card-body">
			<div class="col-sm-12">@include('profile.partials.update-password-form')</div>
		</div>
		<div class="card-body">
			<div class="col-sm-12">@include('profile.partials.delete-user-form')</div>
		</div>
		<div class="card-footer text-muted">
		</div>
	</div>


</div>
@endsection

@section('js')
	$('#currency').select2({
		placeholder: "Please choose category",
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
		ajax: {
			url: '{{ route('ajax.listcurrencies') }}',
			dataType: 'json',
			data: function (params) {
				return {
					_token: '{!! csrf_token() !!}',
					search: params.term,
					type: 'public'
				};
			},
			processResults: function (data) {
				return {
					results: data.map(item => ({
						id: item.id,
						text: `${item.country} (${item.currency_name} - ${item.currency_code})`
					}))
				};
			},
			cache: true
		}
	});
var newOptionCategory = new Option('{{ $user->belongstocurrency?->country }} ({{ $user->belongstocurrency?->currency_name }} - {{ $user->belongstocurrency?->currency_code }})', '{{ $user->belongstocurrency?->id }}', true, true);
$('#currency').append(newOptionCategory).trigger('change');
@endsection
