<!-- <li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Transaction</a>
	<div class="dropdown-menu">
		<a class="dropdown-item" href="{{ route('transactions.index') }}">List</a>
		<a class="dropdown-item" href="{{ route('transactions.create') }}">Create</a>
	</div>
</li>
<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Configuration</a>
	<div class="dropdown-menu">
		<a class="dropdown-item" href="{{ route('categories.index') }}">Category</a>
		<a class="dropdown-item" href="#">Another action</a>
		<a class="dropdown-item" href="#">Something else here</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="#">Separated link</a>
	</div>
</li> -->



<li class="nav-item">
	<a class="nav-link" href="{{ route('transactions.create') }}">Transaction</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="{{ route('categories.index') }}">Category</a>
</li>

