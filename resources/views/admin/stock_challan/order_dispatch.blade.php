@extends('admin.layout.main_app')
@section('title', 'Order Didspatch')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order Didspatch</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Order Didspatch</li>
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
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger">
                                        <p>{{ $message }}</p>
                                    </div>
                                @endif
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{ route('admin.order.dispatch.update') }}" method="post"
                                id="coustomer_add" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $orderlist->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="stock_dispatch_date">Order Dispatch Date</label>
                                            <input type="date" class="form-control" value="{{ $orderlist->order_date }}" readonly />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="challan_number">Order Dispatch Number</label>
                                            <input type="text" class="form-control"value="{{ $orderlist->challan_number }}" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>User</label>
                                        <input type="text" class="form-control" value="{{ $orderlist->user_name }}" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <input type="text" class="form-control" value="{{ $orderlist->branch_name }}" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Item</label>
                                        <input type="text" class="form-control" value="{{ $orderlist->item_name }}" readonly />
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="stock_dispatch_date">Dispatch Date</label>
                                            <input type="text" class="form-control" name="orderdispatchdate" value="{{ $CurrentformattedDate }}" readonly />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="challan_number">Order Dispatch Number</label>
                                            <input type="text" class="form-control" name="orderdispatchnumber" value="{{ $challannumber }}" readonly />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="quantity">Quantity</label>
                                            <input type="text" class="form-control" id="qty" name="qty" value="{{ $orderlist->quantity }}"/>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="rate">Rate</label>
                                            <input type="text" class="form-control" id="rate" name="rate" value="{{ $orderlist->rate }}"/>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="rate">Total Amount</label>
                                            <input type="text" class="form-control" id="total_amount" name="total_amount" value="{{ $orderlist->rate * $orderlist->quantity }}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for="Trash">Trash</label>
                                                <input type="text" min="0" class="form-control"
                                                    id="Trash" name="conditionmaster[]"
                                                    value="{{ $conditiondata['0'] }}" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Moisture">Moisture</label>
                                                <input type="text" min="0" class="form-control"
                                                    id="Moisture" name="conditionmaster[]"
                                                    value="{{ $conditiondata['1'] }}" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Length">Length</label>
                                                <input type="text" min="0" class="form-control"
                                                    id="Length" name="conditionmaster[]"
                                                    value="{{ $conditiondata['2'] }}" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="Mic">Mic</label>
                                                <input type="text" min="0" class="form-control"
                                                    id="Mic" name="conditionmaster[]"
                                                    value="{{ $conditiondata['3'] }}" placeholder="" />
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="RD">RD</label>
                                                <input type="text" min="0" class="form-control"
                                                    id="RD" name="conditionmaster[]"
                                                    value="{{ $conditiondata['4'] }}" placeholder="" />
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="complete" id="complete">
                                            <label class="form-check-label" for="complete">
                                                Order Complete
                                            </label>
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
        $(document).ready(function(){
            $("#rate").keyup(function(){
              var rate = $(this).val();
              var qty = $("#qty").val();

              var totalamount = qty*rate;

              $("#total_amount").val(totalamount);
              
            });
          });
    </script>

@endsection
