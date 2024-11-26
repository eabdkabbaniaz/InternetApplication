<!doctype html>
<html lang="en">
  <head>
  	<title>Folder</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
<style> 

.mt-n1,
.my-n1 {
  margin-top: -0.25rem !important; }

.mr-n1,
.mx-n1 {
  margin-right: -0.25rem !important; }

.mb-n1,
.my-n1 {
  margin-bottom: -0.25rem !important; }

.mr-n2,
.mx-n2 {
  margin-right: -0.5rem !important; }

.mb-n2,
.my-n2 {
  margin-bottom: -0.5rem !important; }

.ml-n2,
.mx-n2 {
  margin-left: -0.5rem !important; }

.m-n3 {
  margin: -1rem !important; }

.mt-n3,
.my-n3 {
  margin-top: -1rem !important; }

.mr-n3,
.mx-n3 {
  margin-right: -1rem !important; }

.mb-n3,
.my-n3 {
  margin-bottom: -1rem !important; }

.ml-n3,
.mx-n3 {
  margin-left: -1rem !important; }

.m-n4 {
  margin: -1.5rem !important; }

.mt-n4,
.my-n4 {
  margin-top: -1.5rem !important; }

.mr-n4,
.mx-n4 {
  margin-right: -1.5rem !important; }

.mb-n4,
.my-n4 {
  margin-bottom: -1.5rem !important; }

.ml-n4,
.mx-n4 {
  margin-left: -1.5rem !important; }

.m-n5 {
  margin: -3rem !important; }

.mt-n5,
.my-n5 {
  margin-top: -3rem !important; }

.mr-n5,
.mx-n5 {
  margin-right: -3rem !important; }

.mb-n5,
.my-n5 {
  margin-bottom: -3rem !important; }

.ml-n5,
.mx-n5 {
  margin-left: -3rem !important; }

.m-auto {
  margin: auto !important; }

.mt-auto,
.my-auto {
  margin-top: auto !important; }

.mr-auto,
.mx-auto {
  margin-right: auto !important; }

.mb-auto,
.my-auto {
  margin-bottom: auto !important; }

.ml-auto,
.mx-auto {
  margin-left: auto !important; }

.text-truncate {
  overflow: hidden;
  -o-text-overflow: ellipsis;
  text-overflow: ellipsis;
  white-space: nowrap; }

.text-left {
  text-align: left !important; }

.text-right {
  text-align: right !important; }

.text-center {
  text-align: center !important; }

body {
  font-family: "Poppins", Arial, sans-serif;
  font-size: 16px;
  line-height: 1.8;
  font-weight: normal;
  background: #f8f9fd;
  color: gray; }

.img {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center; }

.table {
  min-width: 1000px !important;
  width: 100%;
  -webkit-box-shadow: 0px 5px 12px -12px rgba(0, 0, 0, 0.29);
  -moz-box-shadow: 0px 5px 12px -12px rgba(0, 0, 0, 0.29);
  box-shadow: 0px 5px 12px -12px rgba(0, 0, 0, 0.29); }
  .table thead th {
    border: none;
    padding: 30px;
    font-size: 13px;
    font-weight: 500;
    color: gray; }
  .table thead tr {
    background: #fff;
    border-bottom: 4px solid #eceffa; }
  .table tbody tr {
    margin-bottom: 10px;
    border-bottom: 4px solid #f8f9fd; }
    .table tbody tr:last-child {
      border-bottom: 0; }
  .table tbody th, .table tbody td {
    border: none;
    padding: 30px;
    font-size: 14px;
    background: #fff;
    vertical-align: middle; }
  .table tbody td.status span {
    position: relative;
    border-radius: 30px;
    padding: 4px 10px 4px 25px; }
    .table tbody td.status span:after {
      position: absolute;
      top: 9px;
      left: 10px;
      width: 10px;
      height: 10px;
      content: '';
      border-radius: 50%;
}
  .table tbody td.status .active {
    background: #cff6dd;
    color: #1fa750; }
    .table tbody td.status .active:after {
      background: #23bd5a; }
  .table tbody td .img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
}
</style>
	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">{{$Group->name}}</h2>
					<div class="pl-3 email">
						<span>'Added: {{$Group->created_at}}</span>
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
              @forEach($Group->files as $data)
                    <tr class="alert" role="alert">
                    <td class="d-flex align-items-center">
                    <div class="img" style="background-image: url(images/person_3.jpg);"></div>
						      	<div class="pl-3 email">
						      		<span>{{$data->users->email}}</span>
						      		<span>Added:{{$data->created_at}} </span>
						      	</div></td>
                   <td>{{$data->operation}}</td>
                   <td class="status"><span class="active">
                   <a href="{{ route('download.file', ['filename' =>$data->path]) }}" class="btn btn-link">
                {{$data->name}}
            </a>
            </span></td>
            @if($data->operation=="Add")      
            <td>{{$data->created_at}}</td>
            @elseif($data->operation=="update")
              <td>{{$data->updated_at}}</td>
@endif
            						     
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