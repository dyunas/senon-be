<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Laravel</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

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

			.full-height {
				height: 100vh;
			}

			.flex-center {
				align-items: center;
				display: flex;
				justify-content: center;
			}

			.flex-center {
				align-items: left;
				display: flex;
				justify-content: center;
			}

			.position-ref {
				position: relative;
			}

			.top-right {
				position: absolute;
				right: 10px;
				top: 18px;
			}

			.content {
				text-align: center;
			}

			.title {
				font-size: 84px;
			}

			.links>a {
				color: #636b6f;
				padding: 0 25px;
				font-size: 13px;
				font-weight: 600;
				letter-spacing: .1rem;
				text-decoration: none;
				text-transform: uppercase;
			}

			.m-b-md {
				margin-bottom: 30px;
			}

		</style>
	</head>

	<body>
		<div>
			<div class="flex-left position-ref">
				<h2>Hi Liza Marie!</h2>
			</div>
	
			<div class="flex-center position-ref">
				<p>	You have {{ $count ?? '' }} assignments that are currently over due.
					<br/>
					Please visit <a href="http://localhost:8088/#/cms/assignment">http:://localhost:8088/assignment</a> to view the due assignments
				</p>
			</div>
		</div>
	</body>

</html>