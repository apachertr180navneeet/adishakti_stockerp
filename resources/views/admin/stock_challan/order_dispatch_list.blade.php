@extends('admin.layout.main_app')
@section('title', 'Order Dispatch List')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order Dispatch List</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Order Dispatch List</li>
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
                                        <h3 class="card-title">Order Managment List</h3>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                    <div class="col-md-1">

                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('admin.dispatch.serach') }}" method="get">
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
                                            <th>Order dispatch no. </th>
                                            <th>Dispatch Date</th>
                                            <th>Branch</th>
                                            <th>Coustomer Name</th>
                                            <th>Order Number</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stock_challan_list as $stock_challan)
                                            <tr>
                                                <td>{{ $stock_challan->order_dispatch_number }}</td>
                                                <td>{{ $stock_challan->order_dispatch_date }}</td>
                                                <td>{{ $stock_challan->branch_name }}</td>
                                                <td>{{ $stock_challan->user_name }}</td>
                                                <td>{{ $stock_challan->challan_number }}</td>
                                                <td>{{ $stock_challan->qty }}</td>
                                                <td>{{ $stock_challan->rate }}</td>
                                                <td>{{ $stock_challan->qty * $stock_challan->rate }}</td>
                                                <td>
                                                    <a href="{{ route('admin.order.dispatch.view', $stock_challan->id) }}"
                                                        class="btn btn-success">View</a>
                                                    <a href="javascript:void(0)" id="delete-user"
                                                        data-id="{{ $stock_challan->id }}"
                                                        data-url="{{ route('admin.stock.challan.delete', $stock_challan->id) }}"
                                                        class="btn btn-danger delete">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {!! $stock_challan_list->links() !!}
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
