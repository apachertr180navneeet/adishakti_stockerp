@extends('admin.layout.main_app')
@section('title', 'Vendor Master')
@section('content')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Vendor Master</h1>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Vendor Master</li>
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
                                                <h3 class="card-title">Vendor List</h3>
                                            </div>
                                            <div class="col-md-5">
                                            </div>
                                            <div class="col-md-1">
                                                <a href="{{ route('admin.vendor.add') }}" class="btn btn-block btn-primary"><i class="fas fa-plus"></i> Add</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="customer_list" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>S.no.</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone no.</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vendor_list as $vendor)
                                                <tr>
                                                    <td>{{ ++$i }}.</td>
                                                    <td>{{ $vendor->name }}</td>
                                                    <td>{{ $vendor->email }}</td>
                                                    <td>{{ $vendor->phone_number }}</td>
                                                    <td>
                                                        @if($vendor->status =='1')
                                                            <p>Active</p>
                                                        @else
                                                            <p>InActive</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.vendor.edit',$vendor->id) }}" class="btn btn-warning">Edit</a>
                                                        <a href="javascript:void(0)" id="delete-user" data-id="{{ $vendor->id }}" data-url="{{ route('admin.vendor.delete',$vendor->id) }}"  class="btn btn-danger delete">Delete</a>
                                                        @if($vendor->status =='0')
                                                            <a href="javascript:void(0)" data-id="{{ $vendor->id }}" data-status="1" data-url="{{ route('admin.vendor.status',$vendor->id) }}" class="btn btn-success status">Active</a>
                                                        @else
                                                            <a href="javascript:void(0)" data-id="{{ $vendor->id }}" data-status="0" data-url="{{ route('admin.vendor.status',$vendor->id) }}" class="btn btn-danger status">InActive</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-center">
                                            {!! $vendor_list->links() !!}
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
