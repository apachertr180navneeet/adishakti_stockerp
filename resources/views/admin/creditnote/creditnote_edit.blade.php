@extends('admin.layout.main_app')
@section('title', 'Credit Note Edit')
@section('content')
            <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Credit Note Edit</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Credit Note Edit</li>
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
                        <form role="form" action="{{ route('admin.credit.note.update') }}" method="post" id="coustomer_add" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $creditnote->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="credit_note_id">Credit Note</label>
                                    <input type="text" class="form-control" id="credit_note_id" name="credit_note_id" value="{{ $creditnote->credit_note }}" readonly/>
                                    @error('credit_note_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="credit_date">Date</label>
                                    <input type="date" class="form-control" id="credit_date" name="credit_date" value="{{ $creditnote->credit_date }}" placeholder="Enter Date" />
                                    @error('credit_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6 col-sm-offset-3 ml-2">
                                        <label for="type" class="control-label">Type:</label>
                                        <label class="radio-inline ml-2">
                                            <input type="radio" name="type" value="1" name="type" onchange="showHideBranch()" <?php if($creditnote->type == '1'){?> checked="" <?php } ?> id="branchredio"/> Branch
                                        </label>
                                        <label class="radio-inline ml-2">
                                            <input type="radio" name="type" value="0" name="type" onchange="showHideBranch()" <?php if($creditnote->type == '0'){?> checked="" <?php } ?> id="customerredio" /> Customer
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" id="customer" <?php if($creditnote->type == '1'){?> d-none <?php } ?>>
                                    <label>User</label>
                                    <select class="form-control select2bs4 select2-hidden-accessible" id="userid" name="user_id" style="width: 100%;" aria-hidden="true">
                                        <option value="">----Select----</option>
                                        @foreach ($user_list as $user)
                                        <option value="{{ $user->id }}" {{$user->id == $creditnote->user_id  ? 'selected' : ''}}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group d-none" id="branch" <?php if($creditnote->type == '0'){?> d-none <?php } ?>>
                                    <label>Branch</label>
                                    <select class="form-control select2bs4 select2-hidden-accessible" id="branchid" name="branch_id" style="width: 100%;" aria-hidden="true">
                                        <option value="">----Select----</option>
                                        @foreach ($branch_list as $branch)
                                        <option value="{{ $branch->id }}" {{$branch->id == $creditnote->branch_id  ? 'selected' : ''}}>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <select class="form-control select2bs4 select2-hidden-accessible" id="item_id" name="item_id" style="width: 100%;" aria-hidden="true">
                                                <option value="">----Select----</option>
                                                @foreach ($item_list as $item)
                                                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="number" min="0" class="form-control" placeholder="Quantity" name="qty" id="qty">
                                        </div>
                                        <div class="col">
                                            <input type="number" min="0" class="form-control" placeholder="Amount" name="amount" id="amount">
                                        </div>
                                        <div class="col">
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
                                            <td>Total Amount</td>
                                            {{-- <td>Remove Item</td> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="quoteTableBody">
                                        <!-- Quotation rows will be added here -->
                                        @foreach ($creditnoteItem as $creditnoteList)
                                        <tr>
                                            <td>
                                                {{ $creditnoteList->item_name }}
                                                <input type="hidden" name="stockitemid[]" value="{{$creditnoteList->item_id}}">
                                            </td>
                                            <td>
                                                {{ $creditnoteList->credit_quantity }}
                                                <input type="hidden" name="stock_amount[]" value="{{$creditnoteList->credit_quantity}}">
                                            </td>
                                            <td>
                                                {{ $creditnoteList->credit_amount }}
                                                <input type="hidden" name="stock_quantity[]" value="{{$creditnoteList->credit_amount}}">
                                            </td>
                                            <td>
                                                {{ $creditnoteList->crdite_total_amount }}
                                                <input type="hidden" class="itemtotalamount" name="itemtotalamount[]" value="{{$creditnoteList->crdite_total_amount}}">
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
                                            <input type="input" class="form-control" id="grand_total" name="grand_total" value="{{ $creditnote->grand_total }}" placeholder="Final Grand Total" />
                                        </div>
                                        <div class="col">
                                            
                                        </div>
                                    </div>
                                </div>
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
                                            <input type="input" class="form-control" id="add_amount" name="add_amount" value="{{ $creditnote->add_amount }}" placeholder="Final Total Amount" />
                                        </div>
                                        <div class="col">
                                            
                                        </div>
                                    </div>
                                </div>
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
                                            <input type="input" class="form-control" id="final_amunt" name="final_amunt" value="{{ $creditnote->final_amunt }}" placeholder="Final Total Amount" />
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
    $(document).ready(function () {
        $('#addQuote').click(function () {
            var productService = $('#item_id').val();
            var productServiceName = $('#item_id :selected').text();
            var productQty = $('#qty').val();
            var productRate = $(' #amount').val();

            var totalAmount = productQty * productRate ;
            grandTotalAmount = grandTotalAmount + totalAmount; 
            $('#quoteTableBody').append(`<tr>
                                            <td>`+productServiceName+`<input type="hidden" name="stockitemid[]" value="`+productService+`"/></td>
                                            <td>`+productRate+`<input type="hidden" name="stock_amount[]" value="`+productRate+`"/></td>
                                            <td>`+productQty+`<input type="hidden" name="stock_quantity[]" value="`+productQty+`"/></td>
                                            <td>`+totalAmount+`<input type="hidden" name="itemtotalamount[]" value="`+totalAmount+`"/></td>
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
        }else {
            $("#customer").removeClass("d-none");
            $("#branch").addClass("d-none");
        }
    }
</script>


<script>
    $("#add_amount").keyup(function(){
        var grandtotal = $("#grand_total").val();
        var addamount = $("#add_amount").val();
        var final_amunt = grandtotal + addamount;
        $("#final_amunt").val(final_amunt);
    });
</script>
@endsection
