@extends('admin.layout.main_app')
@section('title', 'Order Management Edit')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order Management Edit</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Order Management Edit</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card">
                            <!-- <div class="card-header">
                                                                                                                                                                                                                    <h3 class="card-title">Overhead Detail</h3>
                                                                                                                                                                                                                </div> -->
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{ route('admin.stock.challan.update') }}" method="post"
                                id="coustomer_add" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="stock_dispatch_date">Date</label>
                                            <input type="date" class="form-control" id="stock_dispatch_date"
                                                name="stock_dispatch_date" value="{{ $user->order_date }}"
                                                placeholder="Enter Date" />
                                            @error('stock_dispatch_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="challan_number">Order Number</label>
                                            <input type="text" class="form-control" id="challan_number"
                                                name="challan_number" value="{{ $user->challan_number }}" readonly />
                                            @error('challan_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible" id="customer_id"
                                            name="customer_id" style="width: 100%;" aria-hidden="true">
                                            <option value="">----Select----</option>
                                            @foreach ($user_list as $users)
                                                <option value="{{ $user->id }}"
                                                    {{ $users->id == $user->customer_id ? 'selected' : '' }}>
                                                    {{ $users->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible" id="customer_id"
                                            name="branch_id" style="width: 100%;" aria-hidden="true">
                                            <option value="">----Select----</option>
                                            @foreach ($branch_list as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ $branch->id == $user->branch_id ? 'selected' : '' }}>
                                                    {{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Item</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible" id="item_id"
                                            name="item_id" style="width: 100%;" aria-hidden="true">
                                            <option value="">----Select----</option>
                                            @foreach ($item_list as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $user->item_id ? 'selected' : '' }}>
                                                    {{ $item->item_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="quantity">Quantity</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity"
                                                value="{{ $user->quantity }}" placeholder="Enter Quantity" />
                                            @error('quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="rate">Rate</label>
                                            <input type="text" class="form-control" id="rate" name="rate"
                                                value="{{ $user->rate }}" placeholder="Enter Rate" />
                                            @error('rate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label for="Trash">Trash</label>
                                            <input type="text" min="0" class="form-control"
                                                id="Trash" name="conditionmaster[]"
                                                value="{{ $actualdata['0'] }}" placeholder=""/>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="Moisture">Moisture</label>
                                            <input type="text" min="0" class="form-control"
                                                id="Moisture" name="conditionmaster[]"
                                                value="{{ $actualdata['1'] }}" placeholder="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="Length">Length</label>
                                            <input type="text" min="0" class="form-control"
                                                id="Length" name="conditionmaster[]"
                                                value="{{ $actualdata['2'] }}" placeholder="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="Mic">Mic</label>
                                            <input type="text" min="0" class="form-control"
                                                id="Mic" name="conditionmaster[]"
                                                value="{{ $actualdata['3'] }}" placeholder="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="RD">RD</label>
                                            <input type="text" min="0" class="form-control"
                                                id="RD" name="conditionmaster[]"
                                                value="{{ $actualdata['4'] }}" placeholder="" />
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
            </div>
        </section>

    </div>
    <script>
        function validateInput(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }
    </script>
@endsection
