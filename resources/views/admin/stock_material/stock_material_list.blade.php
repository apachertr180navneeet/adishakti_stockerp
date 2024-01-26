@extends('admin.layout.main_app')
@section('title', 'Stock Material List')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stock Material List</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Stock Material List</li>
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
                                        <h3 class="card-title">Stock Material List</h3>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                    <div class="col-md-1">
                                        <a href="{{ route('admin.stock.material.add') }}"
                                            class="btn btn-block btn-primary"><i class="fas fa-plus"></i> Add</a>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('admin.stock.material.serach') }}" method="get">
                                <div class="row ml-3">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>Start Date:</label>
                                            <div class="input-group">
                                                <input type="date" name="startDate" value="{{ $startDate }}"
                                                    class="form-control float-right" required />
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>End Date:</label>
                                            <div class="input-group">
                                                <input type="date" name="endDate" value="{{ $endDate }}"
                                                    class="form-control float-right" required />
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
                                            <th>Bill no.</th>
                                            <th>Date</th>
                                            <th>Source Location</th>
                                            <th>Destination Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stock_material_list as $stock_material)
                                            <tr>
                                                <td>STKMAT-{{ $stock_material->id }}</td>
                                                <td>{{ $stock_material->stock_material_managemnt_date }}</td>
                                                <td>{{ $stock_material->sourcebranchname }}</td>
                                                <td>{{ $stock_material->destinbranchname }}</td>
                                                <td>
                                                    <a href="{{ route('admin.stock.material.edit', $stock_material->id) }}"
                                                        class="btn btn-success">VIew</a>
                                                    <a href="javascript:void(0)" id="delete-user"
                                                        data-id="{{ $stock_material->id }}"
                                                        data-url="{{ route('admin.stock.material.delete', $stock_material->id) }}"
                                                        class="btn btn-danger delete">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {!! $stock_material_list->links() !!}
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
