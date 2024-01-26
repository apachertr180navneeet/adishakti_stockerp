@extends('admin.layout.main_app')
@section('title', 'Stock In List')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stock In List</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Stock In List</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="card-title">Stock In List</h3>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                    <div class="col-md-1">
                                        <a href="{{ route('admin.stock.in.add') }}" class="btn btn-block btn-primary"><i class="fas fa-plus"></i> Add</a>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('admin.stock.in.serach') }}" method="get">
                                <div class="row ml-3">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>Start Date:</label>
                                            <div class="input-group">
                                                <input type="date" name="startDate" value="{{$startDate}}" class="form-control float-right"  required/>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>End Date:</label>
                                            <div class="input-group">
                                                <input type="date" name="endDate" value="{{$endDate}}" class="form-control float-right" required />
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary mt-4">Search</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="customer_list" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>S.no.</th>
                                            <th>Date</th>
                                            <th>Vendor</th>
                                            <th>Amount</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($stock_list as $stock)
                                        <tr>
                                            <td> STOCKIN-{{ $stock->id }}</td>
                                            <td>{{ $stock->stock_date }}</td>
                                            <td>{{ $stock->name }}</td>
                                            <td>{{ $stock->total_amount }}</td>
                                            <td>{{ $stock->qty }}</td>
                                            <td>
                                                <a href="{{ route('admin.stock.in.edit',$stock->id) }}" class="btn btn-warning">Edit</a>
                                                <a href="javascript:void(0)" id="delete-user" data-id="{{ $stock->id }}" data-url="{{ route('admin.stock.in.delete',$stock->id) }}"  class="btn btn-danger delete">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {!! $stock_list->links() !!}
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
