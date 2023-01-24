<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
	<h3>Ці вакансії підібрані саме для вас!</h3>
	@foreach($vacancies as $vacancy)
		<h4><a href="{{ $vacancy->link }}">{{ $vacancy->title }}</a></h4>
		<div>
			{{ $vacancy->city }}
		</div>
		<div>
			{{ $vacancy->company_name }}
		</div>
		<hr>
	@endforeach
	
</body>
</html>