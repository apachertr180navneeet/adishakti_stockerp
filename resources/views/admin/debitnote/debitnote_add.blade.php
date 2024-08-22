@extends('admin.layout.main_app')
@section('title', 'Debit Note Add')
@section('content')
<style>
    label {
        vertical-align:middle;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Debit Note Add</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Debit Note Add</li>
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
                            <h3 class="card-title">Customer Detail</h3>
                        </div> -->
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('admin.debit.note.store') }}" method="post" id="coustomer_add" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="debit_note_id">Debit Note</label>
                                    <input type="text" class="form-control" id="debit_note_id" name="debit_note_id" value="HTNDEBIT-{{ $debitnotenumber }}" readonly/>
                                    @error('debit_note_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="debit_date">Date</label>
                                    <input type="date" class="form-control" id="debit_date" name="debit_date" value="{{ old('debit_date') }}" placeholder="Enter Date" required/>
                                    @error('debit_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6 col-sm-offset-3 ml-2">
                                        <label for="type" class="control-label">Type:</label>
                                        <label class="radio-inline ml-2">
                                            <input type="radio" name="type" value="1" name="type" onchange="showHideBranch()" id="branchredio" required/> Branch
                                        </label>
                                        <label class="radio-inline ml-2">
                                            <input type="radio" name="type" value="0" name="type" onchange="showHideBranch()" checked="" id="customerredio" required/> Customer
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" id="customer">
                                    <label>User</label>
                                    <select class="form-control select2bs4 select2-hidden-accessible" id="userid" name="user_id" style="width: 100%;" aria-hidden="true">
                                        <option value="">----Select----</option>
                                        @foreach ($user_list as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group d-none" id="branch">
                                    <label>Branch</label>
                                    <select class="form-control select2bs4 select2-hidden-accessible" id="branchid" name="branch_id" style="width: 100%;" aria-hidden="true" required>
                                        <option value="">----Select----</option>
                                        @foreach ($branch_list as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
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
                                            <td width="5%">SN</td>
                                            <td width="*">Item</td>
                                            <td width="8%">Rate</td>
                                            <td width="8%">QTY</td>
                                            <td width="12%">Total Amount</td>
                                        </tr>
                                    </thead>
                                    <tbody id="quoteTableBody">
                                        <!-- Quotation rows will be added here -->
                                        
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
                                            <input type="input" class="form-control" id="grand_total" name="grand_total" value="{{ old('grand_total') }}" placeholder="Final Grand Total" />
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
                                            <input type="input" class="form-control" id="add_amount" name="add_amount" value="{{ old('add_amount') }}" placeholder="Final Total Amount" />
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
                                            <input type="input" class="form-control" id="final_amunt" name="final_amunt" value="{{ old('final_amunt') }}" placeholder="Final Total Amount" />
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
                                            <td>1</td>
                                            <td>`+productServiceName+`<input type="hidden" name="debit_item_id[]" value="`+productService+`"/></td>
                                            <td>`+productRate+`<input type="hidden" name="rate[]" value="`+productRate+`"/></td>
                                            <td>`+productQty+`<input type="hidden" name="qty[]" value="`+productQty+`"/></td>
                                            <td>`+totalAmount+`<input type="hidden" name="totalamount[]" value="`+totalAmount+`"/></td>
                                        </tr>`);
            $('#grand_total').val(grandTotalAmount);
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