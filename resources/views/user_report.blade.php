<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");

body {
    background-color: #f9f9fa
}

.flex {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto
}

@media (max-width:991.98px) {
    .padding {
        padding: 1.5rem
    }
}

@media (max-width:767.98px) {
    .padding {
        padding: 1rem
    }
}

.padding {
    padding: 5rem
}

.card {
    box-shadow: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none
}

.pl-3,
.px-3 {
    padding-left: 1rem !important
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #d2d2dc;
    border-radius: 0;
}

.card .card-title {
    color: #000000;
    margin-bottom: 0.625rem;
    text-transform: capitalize;
    padding: 30px;
}

.card .card-description {
    margin-bottom: .875rem;
    font-weight: 400;
    color: #76838f
}

p {
    font-size: 0.875rem;
    margin-bottom: .5rem;
    line-height: 1.5rem
}

.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar
}

.table,
.jsgrid .jsgrid-table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent
}

.table thead th,
.jsgrid .jsgrid-table thead th {
    border-top: 0;
    border-bottom-width: 1px;
    font-weight: 500;
    font-size: .875rem;
    text-transform: uppercase
}

.table td,
.jsgrid .jsgrid-table td {
    font-size: 0.875rem;
    padding: .875rem 0.9375rem
}

.badge {
    border-radius: 0;
    font-size: 12px;
    line-height: 1;
    padding: .375rem .5625rem;
    font-weight: normal
}
    </style>
    <meta charset="utf-8" />
    <!-- <link rel="stylesheet" href="./report.css" /> -->
    <title>Report App</title>
</head>

<body>

    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="row container d-flex justify-content-center">
                <div class="col-lg-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Logging Table</h2>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                  
                                <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>Login time</th>
                                            <th>Logout time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    @forEach($userdata as $data)
                    <tr>
                    <td>{{$name}}</td>
                   <td>{{$data->created_at}}</td>
                   <td>{{$data->deleted_at}}</td>
                  @if(!$data->deleted_at)
                  <td><label class="badge badge-success">Active</label></td>
                
                @else
                <td><label class="badge badge-danger">Un Active</label></td>
                
              @endif
                    </tr>
   
           @endforeach
                                
                                
                                
</tbody>
                            
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>