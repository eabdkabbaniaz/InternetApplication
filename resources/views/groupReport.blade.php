<!doctype html>
<html lang="en">
  <head>
  	<title>Folder</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">{{$data['name']}}</h2>
					<div class="pl-3 email">
						<span>'Added: {{$data['created_at']}}</span>
						<br />
						<span>Date of Report: {{ Carbon\Carbon::now()}}</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
						<table class="table table-responsive-xl">
						  <thead>
						    <tr>
						      <th>User</th>
						      <th>Operation</th>
						      <th>File</th>
							  <th>Date</th>
						    </tr>
						  </thead>
						  <tbody>
              @forEach($data['files'] as $dat)
                    <tr class="alert" role="alert">
                    <td class="d-flex align-items-center">
                    <div class="img" style="background-image: url(images/person_3.jpg);"></div>
						      	<div class="pl-3 email">
									<!-- {{$users=$dat['users']}} -->
						      		<span>{{$dat['users']['email']}}</span>
						      		<span>Added:{{$dat['created_at']}} </span>
						      	</div></td>
                   <td>{{$dat['operation']}}</td>
                   <td class="status"><span class="active">
                   <a href="{{ route('download.file', ['filename' =>$dat['path']]) }}" class="btn btn-link">
                {{$dat['name']}}
            </a>
            </span></td>
    
              <td>{{$dat['created_at']}}</td>

            						     
                    </tr>
   
           @endforeach
                                

				
						  </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	</body>
</html>