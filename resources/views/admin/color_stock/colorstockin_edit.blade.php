@extends('admin.layout.main_app')
@section('title', 'Color Stock In')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Color Stock In</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Color Stock In</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Color Stock In</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('admin.color.stock.store') }}" method="post" id="coustomer_add" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="stock_date">Date</label>
                                            <input type="date" class="form-control" id="stock_date" name="stock_date"
                                                value="{{ $colorstockIN->date }}" placeholder="Enter Date" required />
                                            @error('stock_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="invoice">Invoive Number</label>
                                            <input type="text" class="form-control" id="invoice" name="invoice"
                                                value="{{ $colorstockIN->invoice_number }}" placeholder="Enter Invoice" required />
                                            @error('invoice')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Company</label>
                                            <select class="form-control select2bs4 select2-hidden-accessible"
                                                name="branch_id" style="width: 100%;" aria-hidden="true" required>
                                                <option value="">----Select----</option>
                                                @foreach ($branch_list as $branch)
                                                    <option {{ $branch->id == $colorstockIN->branch_id ? 'selected' : '' }} value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Vendor</label>
                                            <select class="form-control select2bs4 select2-hidden-accessible"
                                                name="vendor_id" style="width: 100%;" aria-hidden="true" required>
                                                <option value="">----Select----</option>
                                                @foreach ($user_list as $user)
                                                    <option {{ $user->id == $colorstockIN->vendor_id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control select2bs4 select2-hidden-accessible"
                                                id="item_id" name="item_id" style="width: 100%;" aria-hidden="true">
                                                <option value="">----Select----</option>
                                                @foreach ($item_list as $item)
                                                    <option value="{{ $item->id }} . {{ $item->color_code }}">{{ $item->color_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="0" class="form-control" placeholder="Quantity" name="qty" id="qty">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="0" class="form-control" placeholder="Rate" name="amount" id="amount">
                                        </div>
                                        <div class="col-md-3 mt-2">
                                            <button type="button" class="btn btn-sm btn-success" id="addQuote"> +
                                                Add</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td width="12%">Item</td>
                                            <td width="8%">Rate</td>
                                            <td width="8%">QTY</td>
                                            <td width="8%">Total Amount</td>
                                        </tr>
                                    </thead>
                                    <tbody id="quoteTableBody">
                                        <!-- Quotation rows will be added here -->
                                        @foreach ($stockItem as $stockItemList)
                                                <tr>
                                                    <td>
                                                        {{ $stockItemList->color_name }}
                                                        <input type="hidden" name="stockitemid[]"
                                                            value="{{ $stockItemList->color_id }}">
                                                    </td>
                                                    <td>
                                                        {{ $stockItemList->rate }}
                                                        <input type="hidden" name="stock_amount[]"
                                                            value="{{ $stockItemList->rate }}">
                                                    </td>
                                                    <td>
                                                        {{ $stockItemList->qty }}
                                                        <input type="hidden" name="stock_quantity[]"
                                                            value="{{ $stockItemList->qty }}">
                                                    </td>
                                                    <td>
                                                        {{ $stockItemList->total_amount }}
                                                        <input type="hidden" class="itemtotalamount"
                                                            name="itemtotalamount[]"
                                                            value="{{ $stockItemList->total_amount }}">
                                                    </td>
                                                    {{-- <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td> --}}
                                                </tr>
                                            @endforeach

                                    </tbody>
                                </table>
                                <div class="form-group mt-2">
                                    <div class="row">
                                        <div class="col">

                                        </div>
                                        <div class="col">

                                        </div>
                                        <div class="col">

                                        </div>
                                        <div class="col">

                                        </div>
                                        <div class="col">
                                            {{--  <div class="form-group">
                                                <input type="number" min="0" class="form-control" placeholder="L(gadhi)" name="Lgadhi" id="Lgadhi" value="0">
                                            </div>  --}}
                                        </div>
                                        <div class="col totalamountmargin">
                                            <input type="input" class="form-control" id="total_amount" name="finaltotal_amount" style="text-align:right;" value="{{$finalamount}}" placeholder="Final Total Amount" readonly />
                                        </div>
                                        <div class="col">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    {{--  <button type="submit" class="btn btn-primary">Save</button>  --}}
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var grandTotalAmount = 0;
        $(document).ready(function() {
            $('#addQuote').click(function() {
                var productService = $('#item_id').val();
                var itemunit = productService.split(".");
                var item = itemunit['0'];
                var unit = itemunit['1'];
                var productServiceName = $('#item_id :selected').text();
                var productQty = $('#qty').val();
                var productRate = $(' #amount').val();

                var totalAmount = productQty * productRate;
                grandTotalAmount = grandTotalAmount + totalAmount;
                $('#quoteTableBody').append(`<tr>
                                            <td>1</td>
                                            <td>` + productServiceName + `<input type="hidden" name="service_id[]" value="` + item + `" required /></td>
                                            <td>` + productRate + `<input type="hidden" name="rate[]" value="` + productRate + `" required/></td>
                                            <td>` + productQty + `<input type="hidden" name="qty[]" value="` + productQty + `" required/></td>
                                            <td> gm <input type="hidden" name="unit[]" value="gm" required/></td>
                                            <td style="text-align: right;">` + totalAmount + `<input type="hidden" id="removeamount" name="totalamount[]" value="` + totalAmount + `" required/></td>
                                            <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                        </tr>`);
                $('#total_amount').val(grandTotalAmount);
                $('#item_id').val('');
                $('#qty').val('');
                $('#amount').val('');
            });
        });
        $(document).on('click', '.remove-row', function() {
            var removeamount = $(this).closest('tr').find('#removeamount').val();
            var total_amount = $('#total_amount').val();
            var gt = removeamount - total_amount;
            var positivegt = Math.abs(gt);
            $('#total_amount').val(positivegt);
            (this).closest('tr').remove();
        });
    </script>
@endsection
