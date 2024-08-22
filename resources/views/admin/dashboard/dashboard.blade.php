@extends('admin.layout.main_app')
@section('title', 'Dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card align-items-center h-100" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase">User</h5>
                                <p class="card-text text-center font-weight-bold">{{$userCount}}</p>
                                <a href="#" class="btn btn-primary text-uppercase">user list</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card align-items-center h-100" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase">User Active</h5>
                                <p class="card-text text-center font-weight-bold">{{$userCountActive}}</p>
                                <a href="#" class="btn btn-primary text-uppercase">user list</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card align-items-center h-100" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase">User InActive</h5>
                                <p class="card-text text-center font-weight-bold">{{$userCountInActive}}</p>
                                <a href="#" class="btn btn-primary text-uppercase">user list</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
