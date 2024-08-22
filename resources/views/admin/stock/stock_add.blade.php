@extends('admin.layout.main_app')
@section('title', 'Purchase Order Add')
@section('content')
<style>
    .totalamountmargin{
        margin-right: -2%;
    }
</style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Purchase Order Add</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Purchase Order Add</li>
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
                    @if ($message = Session::get('danger'))
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card">
                            <!-- <div class="card-header">
                                <h3 class="card-title">Customer Detail</h3>
                            </div> -->
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{ route('admin.stock.in.store') }}" method="post"
                                id="coustomer_add" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="stock_date">Date</label>
                                                <input type="date" class="form-control" id="stock_date" name="stock_date"
                                                    value="{{ old('stock_date') }}" placeholder="Enter Date" required />
                                                @error('stock_date')
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
                                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
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
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    id="item_id" name="item_id" style="width: 100%;" aria-hidden="true">
                                                    <option value="">----Select----</option>
                                                    @foreach ($item_list as $item)
                                                        <option value="{{ $item->id }} . {{ $item->unit_code }}">{{ $item->item_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" min="0" class="form-control" placeholder="Quantity" name="qty" id="qty">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" min="0" class="form-control" placeholder="Rate" name="amount" id="amount">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" min="0" class="form-control" placeholder="L(gadhi)" name="itemgadhi" id="itemgadhi">
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
                                                <td width="5%">SN</td>
                                                <td width="12%">Item</td>
                                                <td width="8%">Rate</td>
                                                <td width="8%">QTY</td>
                                                <td width="8%">Unit</td>
                                                <td width="8%">Amount</td>
                                                <td width="8%">L(gadhi)</td>
                                                <td width="8%">Remove</td>
                                            </tr>
                                        </thead>
                                        <tbody id="quoteTableBody">
                                            <!-- Quotation rows will be added here -->

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
                                                <div class="form-group">
                                                    <label>L(gadhi)</label>
                                                    <input type="number" min="0" class="form-control" placeholder="L(gadhi)" name="Lgadhi" id="Lgadhi" value="100" required>
                                                </div>
                                            </div>
                                            <div class="col totalamountmargin">
                                                <input type="input" class="form-control" id="total_amount" name="finaltotal_amount" style="text-align:right;" value="0" placeholder="Final Total Amount" readonly />
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var grandTotalAmount = 0;
        $(document).ready(function() {
            $('#addQuote').click(function() {
                if($('#item_id').val() == "") {
                    alert('Please select Item first.');
                    return false;
                }
                if($('#qty').val() == "") {
                    alert('Please select Item first.');
                    return false;
                }
                if($('#amount').val() == "") {
                    alert('Please select Item first.');
                    return false;
                }
                if($('#itemgadhi').val() == "") {
                    alert('Please select Item first.');
                    return false;
                }
                var productService = $('#item_id').val();
                var itemunit = productService.split(".");
                var item = itemunit['0'];
                var unit = itemunit['1'];
                var productServiceName = $('#item_id :selected').text();
                var productQty = $('#qty').val();
                var productRate = $('#amount').val();
                var itemgadhi = $('#itemgadhi').val();

                var totalAmount = productQty * productRate;
                grandTotalAmount = grandTotalAmount + totalAmount;
                $('#quoteTableBody').append(`<tr>
                                            <td>1</td>
                                            <td>` + productServiceName + `<input type="hidden" name="service_id[]" value="` + item + `" required /></td>
                                            <td>` + productRate + `<input type="hidden" name="rate[]" value="` + productRate + `" required/></td>
                                            <td>` + productQty + `<input type="hidden" name="qty[]" value="` + productQty + `" required/></td>
                                            <td>` + unit + `<input type="hidden" name="unit[]" value="` +unit + `" required/></td>
                                            <td style="text-align: right;">` + totalAmount + `<input type="hidden" id="removeamount" name="totalamount[]" value="` + totalAmount + `" required/></td>
                                            <td style="text-align: right;">` + itemgadhi + `<input type="hidden" id="" name="itemgadhidata[]" value="` + itemgadhi + `" required/></td>
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
