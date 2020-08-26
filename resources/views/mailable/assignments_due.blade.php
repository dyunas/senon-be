<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Senon Adjuster</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

		<!-- Styles -->
		<style>
			html,
			body {
				background-color: #fff;
				color: #636b6f;
				font-family: 'Nunito', sans-serif;
				font-weight: 200;
				height: 100vh;
				margin: 0;
			}
		</style>
	</head>

	<body>
		<div class="container">
			<h3>Dear Team,</h3>
			<br/>
			<p class="lead">Please update status:</p>
			<br/>
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td scope="col"><span class="font-weight-bold">Ref. No.:</span></td>
						<td>{{ $due->ref_no }}</td>
					</tr>
					<tr>
						<td scope="col"><span class="font-weight-bold">Adjuster:</span></td>
						<td>{{ $due->adjuster }}</td>
					</tr>
					<tr>
						<td scope="col"><span class="font-weight-bold">Insured:</span></td>
						<td>{{ $due->name_insured }}</td>
					</tr>
					<tr>
						<td scope="col"><span class="font-weight-bold">Status:</span></td>
						<td>{{ $due->status_list->status }}</td>
					</tr>
					<tr>
						<td scope="col"><span class="font-weight-bold">Due Date:</span></td>
						<td>{{ $due->due_date }}</td>
					</tr>
					<tr>
						<td scope="col"><span class="font-weight-bold">Last Update:</span></td>
						<td>{{ $due->updated_at }}</td>
					</tr>
				</tbody>
			</table>
			<br/>
			<p class="lead">Thank you.</p>
		</div>
	</body>

</html>
