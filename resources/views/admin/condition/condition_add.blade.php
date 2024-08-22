@extends('admin.layout.main_app')
@section('title', 'Chemical Master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Chemical Master</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Chemical Master</li>
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
                                <h3 class="card-title">Chemical Add</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="{{ route('admin.condition.store') }}" method="post"
                                id="coustomer_add" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Chemical Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name') }}" placeholder="Enter Chemical Name" required />
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Unit</label>
                                            <select class="form-control select2bs4 select2-hidden-accessible" name="unit_id" style="width: 100%;" aria-hidden="true" required>
                                                <option value="">----Select----</option>
                                                @foreach ($unit_list as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('unit_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group col-md-4">
                                            <label for="value">Rate Per Meter</label>
                                            <input type="text" class="form-control" id="value" name="value"
                                                value="{{ old('value') }}" placeholder="Enter Rate Per Meter" required/>
                                            @error('value')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="type" id="base_unit" value="base_unit" checked>
                                                <label class="form-check-label" for="type">Base Unit</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="type" id="sub_unit" value="sub_unit">
                                                <label class="form-check-label" for="type">Sub Unit</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <h5 class="col-md-6">Add Sub Chemical</h5>
                                        <div class="form-group col-md-4">
                                            <label for="metervalue">Meter Value</label>
                                            <input type="text" class="form-control" id="metervalue" name="metervalue"
                                                value="{{ old('metervalue') }}" placeholder="Enter meter value" readonly />
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chemical</label>
                                            <select name="chamical" id="chamical" class="form-control">
                                              <option value="">Select Chemical</option>
                                              @foreach ($condition_list as $condition)
                                              <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Qty</label>
                                        <input type="text" name="qty" id="qty" class="form-control" placeholder="" />
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-sm btn-success mt-2" id="addQuote"> +
                                            Add</button>
                                    </div>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td width="12%">Chemical</td>
                                            <td width="8%">QTY</td>
                                            <td width="8%">QTY/meter value</td>
                                            <td width="8%">Calculation</td>
                                            <td width="8%">Remove</td>
                                        </tr>
                                    </thead>
                                    <tbody id="quoteTableBody">
                                        <!-- Quotation rows will be added here -->

                                    </tbody>
                                </table>
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
                let grandtotal = 0;
                $('#addQuote').click(function() {
                    var meterValue = $("#metervalue").val();
                    var chamical_id = $('#chamical').val();
                    var chamical_name = $('#chamical :selected').text();
                    var qty = $('#qty').val();
                    var meter_value = qty +'/'+ meterValue;
                    var calculation = qty / meterValue;
                    grandtotal += calculation;

                    if (!meterValue) {
                        alert("Please add meter value first!");
                        return;
                    }
                    $('#quoteTableBody').append(`<tr>
                                            <td>` + chamical_name +
                                            `<input type="hidden" name="chemical_id[]" value="` + chamical_id + `" required /></td>
                                            <td>` + qty + `<input type="hidden" name="chemical_qty[]" value="` +
                                                qty + `" required/></td>
                                            <td>` + meter_value + `</td>
                                            <td>` + calculation + `<input type="hidden" name="chemical_calculation[]" value="` +
                                                calculation + `" required/></td>
                                            <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                        </tr>`);
                    $('#value').val(grandtotal);
                    $('#qty').val('');
                    $('#qty').val('');
                });
                $(document).on('click', '.remove-row', function() {
                    const removeColorAmount = +$(this).closest("tr").find("[name='chemical_calculation[]']").val();
                    grandtotal -= removeColorAmount;
                    $('#value').val(Math.abs(grandtotal));
                    (this).closest('tr').remove();
                });
            });
    </script>
    <script>
            $(document).ready(function(){
                // When a radio button is clicked
                $('#sub_unit').on('click', function(){
                    // Check if the radio button with value 'readonly' is checked
                    if($(this).val() === 'sub_unit'){
                        // Make the input field readonly
                        $('#metervalue').prop('required', false);
                        $('#metervalue').prop('readonly', false);
                    } else {
                        // Make the input field editable
                        $('#metervalue').prop('required', true);
                        $('#metervalue').prop('readonly', true);
                    }
                });

                $('#base_unit').on('click', function(){
                    // Check if the radio button with value 'readonly' is checked
                    if($(this).val() === 'base_unit'){
                        // Make the input field editable
                        $('#metervalue').prop('required', true);
                        $('#metervalue').prop('readonly', true);
                    } else {
                        // Make the input field readonly
                        $('#metervalue').prop('required', false);
                        $('#metervalue').prop('readonly', false);
                    }
                });
            });
    </script>
@endsection
