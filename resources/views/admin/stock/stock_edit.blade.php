@extends('admin.layout.main_app')
@section('title', 'Stock Edit')
@section('content')
<style>
    .totalamountmargin{
        margin-right: 9%;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stock Edit</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Stock In Edit</li>
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
                        <form role="form" action="{{ route('admin.stock.in.update') }}" method="post" id="coustomer_add" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $stock->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="stock_date">Stock In Bill No.</label>
                                    <input type="text" class="form-control" value="STOCKIN-{{ $stock->id }}" />
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="stock_date">Date</label>
                                            <input type="date" class="form-control" id="stock_date" name="stock_date" value="{{ $stock->stock_date }}" placeholder="Enter Date" />
                                            @error('stock_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group" >
                                            <label>Vendor</label>
                                            <select class="form-control select2bs4 select2-hidden-accessible" name="vendor_id" style="width: 100%;" aria-hidden="true">
                                                <option value="">----Select----</option>
                                                @foreach ($user_list as $users)
                                                <option value="{{ $users->id }}" {{$users->id == $stock->vendor_id  ? 'selected' : ''}}>{{ $users->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control select2bs4 select2-hidden-accessible" id="item_id" name="item_id" style="width: 100%;" aria-hidden="true">
                                                <option value="">----Select----</option>
                                                @foreach ($item_list as $item)
                                                <option value="{{ $item->id }} . {{ $item->unit_code }}">{{ $item->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="0" class="form-control" placeholder="Quantity" name="qty" id="qty">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="0" class="form-control" placeholder="Amount" name="amount" id="amount">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-sm btn-success" id="addQuote"> + Add</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Item</td>
                                            <td>Rate</td>
                                            <td>QTY</td>
                                            <td>Unit</td>
                                            <td>Total Amount</td>
                                            <td>Remove Item</td>
                                        </tr>
                                    </thead>
                                    <tbody id="quoteTableBody">
                                        <!-- Quotation rows will be added here -->
                                        @foreach ($stockItem as $stockItemList)
                                        <tr>
                                            <td>
                                                {{ $stockItemList->item_name }}
                                                <input type="hidden" name="stockitemid[]" value="{{$stockItemList->item_id}}">
                                            </td>
                                            <td>
                                                {{ $stockItemList->stock_amount }}
                                                <input type="hidden" name="stock_amount[]" value="{{$stockItemList->stock_amount}}">
                                            </td>
                                            <td>
                                                {{ $stockItemList->stock_quantity }}
                                                <input type="hidden" name="stock_quantity[]" value="{{$stockItemList->stock_quantity}}">
                                            </td>
                                            <td>
                                                {{ $stockItemList->unit }}
                                                <input type="hidden" name="stock_unit[]" value="{{$stockItemList->unit}}">
                                            </td>
                                            <td>
                                                {{ $stockItemList->itemtotalamount }}
                                                <input type="hidden" class="itemtotalamount" name="itemtotalamount[]" id="removeamount" value="{{$stockItemList->itemtotalamount}}">
                                            </td>
                                            <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
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
                                        <div class="col totalamountmargin">
                                            <input type="input" class="form-control" id="total_amount" name="finaltotal_amount" value="{{ $stock->total_amount }}" placeholder="Final Total Amount" readonly />
                                        </div>
                                        <div class="col">
                                            
                                        </div>
                                        <div class="col">
                                            
                                        </div>
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
    $(document).ready(function() {
        $('#addQuote').click(function () {
            var previousTotalAmount = $("#total_amount").val();
            previousTotalAmount = parseInt(previousTotalAmount);
            var productService = $('#item_id').val();
            var itemunit = productService.split(".");
            var item = itemunit['0'];
            var unit = itemunit['1'];
            var productServiceName = $('#item_id :selected').text();
            var productQty = $('#qty').val();
            productQty = parseInt(productQty);
            var productRate = $('#amount').val();
            productRate = parseInt(productRate);
            var totalAmount = productQty * productRate;
            totalAmount = parseInt(totalAmount);
            grandTotalAmount = previousTotalAmount + totalAmount;
            $('#quoteTableBody').append(`<tr>
                                            <td>` + productServiceName + `<input type="hidden" name="service_id[]" value="` + item + `" required /></td>
                                            <td>` + productRate + `<input type="hidden" name="rate[]" value="` + productRate + `" required/></td>
                                            <td>` + productQty + `<input type="hidden" name="qty[]" value="` + productQty + `" required/></td>
                                            <td>` + unit + `<input type="hidden" name="unit[]" value="` +unit + `" required/></td>
                                            <td>` + totalAmount + `<input type="hidden" id="removeamount" name="totalamount[]" value="` + totalAmount + `" required/></td>
                                            <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                        </tr>`);
            $('#total_amount').val(grandTotalAmount);
            $('#item_id').val('');
            $('#qty').val('');
            $('#amount').val('');
        });
    });
    $(document).on('click','.remove-row', function()
    {
        var removeamount = $(this).closest('tr').find('#removeamount').val();
        var total_amount = $('#total_amount').val();
        var gt = parseInt(removeamount) - parseInt(total_amount);
        var positivegt = Math.abs(gt);
        $('#total_amount').val(positivegt);
        (this).closest('tr').remove();
    });
</script>
@endsection
