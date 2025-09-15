@extends('layouts.pdf-layout')

@section('title', 'Transaction')

@section('content')
		<table>
			<thead>
				<tr>
					<th colspan="2"><span class="center bold">Transaction</span></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Reference No : <span class="bold red">
						{{ 'DAT-'.\Carbon\Carbon::parse($transaction->created_at)->format('ym').str_pad( $transaction->id, 3, "0", STR_PAD_LEFT) }}
					</span>
					</td>
					<td>
						Date : <span class="bold">{{ \Carbon\Carbon::parse($transaction->created_at)->format('D, j F Y') }}</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">Name : {{ $transaction->belongstouser->name }}</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<th >Type : {{ ucwords(Str::lower($transaction->type)) }}</th>
					<th >Transaction Date : {{ \Carbon\Carbon::parse($transaction->date)->format('D, j F Y') }}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Category : {{ $transaction->belongstocategory->category }}</td>
					<td>Amount : {{ \Auth::user()->belongstouser->belongstocurrency->currency_code }} {{ $transaction->amount }}</td>
				</tr>
			</tbody>
			@if($transaction->hasmanyupload()->get()->count() > 0)
			<thead>
				<tr>
					<th colspan="2"><span class="center">Attachment</span></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> <img src="" alt=""> </td>
					<td> <img src="" alt=""> </td>
				</tr>
			</tbody>
			@endif
		</table>
@endsection
