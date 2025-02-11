<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>{{ config('app.name', 'Laravel') }}</title>
	<style>
/* Set A4 size */
* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

@page {
	size:  21cm 29.7cm;
	margin: 0;
}

/* Set content to fill the entire A4 page */
html,
body {
	width: 210mm;
	height: 297mm;
	margin: 0;
	padding: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 12px; /* Set default font size for the body */
}

/* Style content with shaded background */
.content {
	width: 90%;
	height: 90%;
	padding: 30;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	background-color: #f0f0f0; /* Light gray shade */
}

/* Center class for centering elements */
.center {
	display: flex;
	justify-content: center;
	align-items: center;
	text-align: center;
}

/* Page break styles */
.page-break {
	page-break-before: always; /* Start a new page before the element */
	page-break-after: always; /* Or, start a new page after the element */
}

/* Headings styles with font sizes */
h1 {
	font-size: 24px;
	font-weight: bold;
	text-align: center;
	margin-bottom: 20px;
}

h2 {
	font-size: 20px;
	font-weight: bold;
	margin-bottom: 15px;
}

h3 {
	font-size: 18px;
	font-weight: bold;
	margin-bottom: 10px;
}

/* Paragraph styles with font size */
p {
	font-size: 14px;
	line-height: 1.6;
	margin-bottom: 15px;
}

/* Bold and underline styles */
.bold {
	font-weight: bold;
}

.red {
	color: red;
}

.underline {
	text-decoration: underline;
}

/* Unordered list styles */
ul {
	list-style-type: disc;
	margin-left: 20px;
	margin-bottom: 15px;
	font-size: 14px; /* Set font size for unordered lists */
}

/* Ordered list styles */
ol {
	list-style-type: decimal;
	margin-left: 20px;
	margin-bottom: 15px;
	font-size: 14px; /* Set font size for ordered lists */
}

/* Table styles */
table {
	width: 100%;
	border-collapse: collapse;
	margin-bottom: 20px;
	font-size: 14px; /* Set font size for table content */
	page-break-inside: auto;
}

th,
td {
	border: 1px solid #ccc;
	padding: 10px;
	text-align: left;
	page-break-inside: avoid;
}

th {
	background-color: #d9e9ff; /* Light blue background */
	font-weight: bold;
}

tr:nth-child(even) {
	background-color: #f0f0f0; /* Light gray background for even rows */
}

	</style>
</head>

<body>
	<div class="content">
		<!-- Your content goes here -->
		<h1>{{ config('app.name', 'Laravel') }}</h1>

		<table>
			<thead>
				<tr>
					<th colspan="2"><span class="center bold">Transaction</span></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Reference No : <span class="bold red">
						{{ 'T-'.\Carbon\Carbon::parse($transaction->created_at)->format('ym').str_pad( $transaction->id, 3, "0", STR_PAD_LEFT) }}
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
					<td>Amount : RM{{ $transaction->amount }}</td>
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
	</div>
</body>
</html>
