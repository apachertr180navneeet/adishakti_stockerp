@extends('admin.layout.main_app')
@section('title', 'Stock Shifting')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stock Shifting</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Stock Shifting</li>
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
                            <form role="form" action="{{ route('admin.stock.dispatch.update') }}" method="post"
                                id="coustomer_add" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $stock->id }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="stock_date">Stock Dispatch Bill</label>
                                        <input type="text" class="form-control" value="STKDISP-{{ $stock->id }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="stock_date">Date</label>
                                        <input type="date" class="form-control" id="stock_date" name="stock_date"
                                            value="{{ $stock->stock_date }}" placeholder="Enter Date" required />
                                        @error('stock_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>From Company</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible" name="from_id"
                                            id="from_id" style="width: 100%;" aria-hidden="true" required>
                                            <option value="">----Select----</option>
                                            @foreach ($branch_list as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ $branch->id == $stock->from_id ? 'selected' : '' }}>
                                                    {{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--  <div class="form-group">
                                        <div class="col-sm-6 col-sm-offset-3 ml-2">
                                            <label for="type" class="control-label">Type:</label>
                                            <label class="radio-inline ml-2">
                                                <input type="radio" name="type" value="1"
                                                    onchange="showHideBranch()" {{ $stock->type === '1' ? 'checked' : '' }}
                                                    id="branchredio" required />
                                                Branch
                                            </label>
                                            <label class="radio-inline ml-2">
                                                <input type="radio" name="type" value="0"
                                                    onchange="showHideBranch()" {{ $stock->type === '0' ? 'checked' : '' }}
                                                    id="customerredio" required /> Customer
                                            </label>
                                        </div>
                                    </div>  --}}
                                    {{--  <div class="form-group <?php if($stock->type == '1'){?> d-none <?php } ?>" id="customer">
                                        <label>Customer</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible"
                                            name="vendor_to_id" style="width: 100%;" aria-hidden="true">
                                            <option value="">----Select----</option>
                                            @foreach ($user_list as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $user->id == $stock->vendor_to_id ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>  --}}
                                    <div class="form-group" id="branch">
                                        <label>Branch</label>
                                        <select class="form-control select2bs4 select2-hidden-accessible"
                                            name="branch_to_id" id="branch_to_id" style="width: 100%;" aria-hidden="true">
                                            <option value="">----Select----</option>
                                            @foreach ($branch_list as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ $branch->id == $stock->branch_to_id ? 'selected' : '' }}>
                                                    {{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="item_id" name="item_id" style="width: 100%;" aria-hidden="true">
                                                    <option value="">----Select----</option>
                                                    @foreach ($item_list as $item)
                                                        <option value="{{ $item->id }}">{{ $item->item_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Quantity"
                                                    name="qty" id="qty">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Amount"
                                                    name="amount" id="amount">
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-sm btn-success" id="addQuote"> +
                                                    Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Item</td>
                                                <td>Rate</td>
                                                <td>QTY</td>
                                                <td>Total Amount</td>
                                                {{-- <td>Remove Item</td> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="quoteTableBody">
                                            <!-- Quotation rows will be added here -->
                                            @foreach ($stockItem as $stockItemList)
                                                <tr>
                                                    <td>
                                                        {{ $stockItemList->item_name }}
                                                        <input type="hidden" name="stockitemid[]"
                                                            value="{{ $stockItemList->item_id }}">
                                                    </td>
                                                    <td>
                                                        {{ $stockItemList->stock_amount }}
                                                        <input type="hidden" name="stock_amount[]"
                                                            value="{{ $stockItemList->stock_amount }}">
                                                    </td>
                                                    <td>
                                                        {{ $stockItemList->stock_quantity }}
                                                        <input type="hidden" name="stock_quantity[]"
                                                            value="{{ $stockItemList->stock_quantity }}">
                                                    </td>
                                                    <td>
                                                        {{ $stockItemList->itemtotalamount }}
                                                        <input type="hidden" class="itemtotalamount"
                                                            name="itemtotalamount[]"
                                                            value="{{ $stockItemList->itemtotalamount }}">
                                                    </td>
                                                    {{-- <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="form-group">
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

                                            </div>
                                            <div class="col">
                                                <input type="input" class="form-control" id="total_amount"
                                                    name="finaltotal_amount" value="{{ $stock->total_amount }}"
                                                    placeholder="Final Total Amount" />
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
        var grandTotalAmount = 0;
        $(document).ready(function() {
            $('#addQuote').click(function() {
                var previousTotalAmount = $("#total_amount").val();
                previousTotalAmount = parseInt(previousTotalAmount);
                var productService = $('#item_id').val();
                var productServiceName = $('#item_id :selected').text();
                var productQty = $('#qty').val();
                var productRate = $(' #amount').val();

                var totalAmount = productQty * productRate;
                grandTotalAmount = previousTotalAmount + totalAmount;
                $('#quoteTableBody').append(`<tr>
                                            <td>` + productServiceName +
                    `<input type="hidden" name="stockitemid[]" value="` + productService + `"/></td>
                                            <td>` + productRate +
                    `<input type="hidden" name="stock_amount[]" value="` + productRate + `"/></td>
                                            <td>` + productQty +
                    `<input type="hidden" name="stock_quantity[]" value="` + productQty + `"/></td>
                                            <td>` + totalAmount +
                    `<input type="hidden" name="itemtotalamount[]" value="` + totalAmount + `"/></td>
                                        </tr>`);
                $('#total_amount').val(grandTotalAmount);
                $('#item_id').val('');
                $('#qty').val('');
                $('#amount').val('');
            });
        });
    </script>
    <script>
        function showHideBranch() {
            var selectedType = $('input[name="type"]:checked').val();
            if (selectedType == '1') {
                $("#customer").addClass("d-none");
                $("#branch").removeClass("d-none");
            } else {
                $("#customer").removeClass("d-none");
                $("#branch").addClass("d-none");
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#from_id').on('change', function() {
                var formbranch = $(this).val();
                var tobranch = $('#branch_to_id');
                var tobranchselected = tobranch.find('option[value="' + formbranch + '"]');
                tobranchselected.prop('disabled', true);
            });
        });
    </script>
@endsection
