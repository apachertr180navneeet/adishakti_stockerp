@extends('admin.layout.main_app')
@section('title', 'Color Master')
@section('content')
            <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Color Master</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Color Master</li>
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
                            <h3 class="card-title">Color Edit</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('admin.color.update') }}" method="post" id="coustomer_add" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="color_name">Color Name</label>
                                        <input type="text" class="form-control" id="color_name" name="color_name" value="{{ $user->color_name }}" placeholder="Enter Name" required/>
                                        @error('color_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="color_code">Color Code</label>
                                        <input type="text" class="form-control" id="color_code" name="color_code" value="{{ $user->color_code }}" placeholder="Enter Code" required/>
                                        @error('color_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="rate_per_gram">Calculation on Meter</label>
                                        <input type="text" class="form-control" id="metervalue" name="metervalue" value="{{ $user->meter_value }}" placeholder="Enter Rate Per Meter"/>
                                        @error('rate_per_gram')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="rate_per_gram">Quantity on meters (GM)</label>
                                        <input type="text" class="form-control" id="qty_on_meter" name="qty_on_meter" value="{{ $user->qty_on_meter }}" placeholder="Enter Rate Per Meter" onkeyup="calculationusagevalue()"/>
                                        @error('rate_per_gram')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="rate_per_gram">Rate per KG(1000 Gm)</label>
                                        <input type="text" class="form-control" id="rate_per_kg" name="rate_per_kg" value="{{ $user->rate_per_kg }}" placeholder="Enter Rate Per Meter" onkeyup="calculationratevalue()" required/>
                                        @error('rate_per_gram')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="rate_per_gram">Usage per Meter (Gm)</label>
                                        <input type="text" class="form-control" id="usage_per_gram" name="usage_per_gram" value="{{ $user->usage_per_gram }}" placeholder="Enter Rate Per Meter" required/>
                                        @error('rate_per_gram')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="rate_per_gram">Rate per Meter (Rs)</label>
                                        <input type="text" class="form-control" id="rate_per_gram" name="rate_per_gram" value="{{ $user->rate_per_gram }}" placeholder="Enter Rate Per Meter" required/>
                                        @error('rate_per_gram')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{--  <div class="form-group col-md-6">
                                        <label for="current_value">Opening Stock (GM)</label>
                                        <input type="text" class="form-control" id="current_value" name="current_value"
                                            value="{{ $user->current_value }}" placeholder="Enter Current value"/>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>  --}}
                                    <div class="form-group col-md-6">
                                        <label for="current_value">Show Color :- </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_group" id="yes" value="1" @if ($user->is_group == 1) Checked @endif>
                                            <label class="form-check-label" for="yes">yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_group" id="no" value="0" @if ($user->is_group == 0) Checked @endif>
                                            <label class="form-check-label" for="no">no</label>
                                        </div>
                                    </div>
                                </div>
                                  <div class="form-group">
                                    <label>Color Combination</label>
                                </div>
                                {{--  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Combination Color</label>
                                            <select name="combination_color" id="combination_color" class="form-control">
                                              <option value="">Select Color</option>
                                              @foreach ($color_list as $color)
                                              <option value="{{ $color->color_name }}">{{ $color->color_name }}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Combination Gm</label>
                                        <input type="text" name="combination_gm" id="combination_gm" class="form-control" placeholder="" />
                                    </div>  --}}
                                    {{--  <div class="col-md-4">
                                        <button type="button" class="btn btn-sm btn-success mt-2" id="addQuote"> +
                                            Add</button>
                                    </div>  --}}
                                {{--  </div>  --}}

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td width="12%">Color</td>
                                            <td width="8%">Gram</td>
                                            <td width="8%"></td>
                                            {{--  <td width="8%">Remove</td>  --}}
                                        </tr>
                                    </thead>
                                    <tbody id="quoteTableBody">
                                        <!-- Quotation rows will be added here -->
                                        @foreach ($color_combination as $colorcombination)
                                        @php
                                            $gm = $colorcombination->gram;
                                            $mv = $user->meter_value;
                                            $amount = $gm * $mv; 
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ $colorcombination->name }}
                                                <input type="hidden" name="name[]" value="{{$colorcombination->name}}">
                                            </td>
                                            <td>
                                                {{--  {{ $amount }}  --}}
                                                <input type="text" name="gm[]" value="{{$colorcombination->gram}}">
                                            </td>
                                            <td>
                                                {{ $amount }}
                                                <input type="hidden" name="chemical_calculation[]" value="{{ $amount }}" required/>
                                            </td>
                                            {{--  <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>  --}}
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
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
    function calculationusagevalue() {
        var decimalPlaces = 2;
        var metervalue = document.getElementById("metervalue").value;
        var qty_on_meter = document.getElementById("qty_on_meter").value;
        var calculationusagevalue = metervalue / qty_on_meter;
        var usagefinalvalue = calculationusagevalue.toFixed(decimalPlaces);;
        $('#usage_per_gram').val(usagefinalvalue);
    }
    function calculationratevalue() {
        console.log("hello world");
        var decimalPlaces = 2;
        //var usage_per_gram = document.getElementById("usage_per_gram").value;
         var metervalue = document.getElementById("metervalue").value;
        var rate_per_kg = document.getElementById("rate_per_kg").value;
        var qty_on_meter = document.getElementById("qty_on_meter").value;
        calculation1 = qty_on_meter/1000;
        calculation2 = rate_per_kg/metervalue;
        var calculationratevalue = calculation1*calculation2;
        var ratefinalvalue = calculationratevalue.toFixed(decimalPlaces);;
        $('#rate_per_gram').val(ratefinalvalue);
    }
    
    $(document).ready(function() {
        var grandtotal = 0;
        $('#addQuote').click(function() {
                var meterValue = $("#metervalue").val();
                var combination_colorname = $('#combination_color').val();
                var combination_colorname = $('#combination_color :selected').text();
                var combination_gm = $('#combination_gm').val();
                var calculation = combination_gm;
                var decimalPlacescal = 4; // Number of decimal places
                var roundedValueCal = calculation.toFixed(decimalPlacescal);
                grandtotal += parseFloat(roundedValueCal);

                $('#quoteTableBody').append(`<tr>
                                            <td>` + combination_colorname +
                    `<input type="hidden" name="name[]" value="` + combination_colorname + `" required /></td>
                                            <td>` + combination_gm + `<input type="hidden" name="gm[]" value="` +
                                                combination_gm + `" required/></td>
                                                <td>` + roundedValueCal + `<input type="hidden" name="chemical_calculation[]" value="` +
                                                roundedValueCal + `" required/></td>
                                            <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                        </tr>`);
                $('#usage_per_gram').val(grandtotal);                    
                $('#combination_color').val('');
                $('#combination_gm').val('');
            });
        });


        $(document).on('click', '.remove-row', function() {
            let grandtotal = $('#usage_per_gram').val();
            const removeColorAmount = +$(this).closest("tr").find("[name='chemical_calculation[]']").val();
            grandtotal -= removeColorAmount;
            $('#usage_per_gram').val(Math.abs(grandtotal));
            (this).closest('tr').remove();
        });

        
</script>
@endsection
