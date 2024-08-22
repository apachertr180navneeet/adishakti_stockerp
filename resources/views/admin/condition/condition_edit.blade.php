@extends('admin.layout.main_app')
@section('title', 'Edit Chemical Master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Chemical Master</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Chemical Master</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Chemical</h3>
                            </div>
                            <form role="form" action="{{ route('admin.condition.update', $user->id) }}" method="post"
                                  id="chemical_edit" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Chemical Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{ old('name', $user->name) }}" placeholder="Enter Chemical Name" required />
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Unit</label>
                                            <select class="form-control select2bs4 select2-hidden-accessible" name="unit_id" style="width: 100%;" aria-hidden="true" required>
                                                <option value="">----Select----</option>
                                                @foreach ($unit_list as $unit)
                                                    <option value="{{ $unit->id }}" {{ $user->unit_id == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->unit_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="value">Rate Per Meter</label>
                                            <input type="text" class="form-control" id="value" name="value"
                                                   value="{{ old('value', $user->value) }}" placeholder="Enter Rate Per Meter" required />
                                            @error('value')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="type" id="base_unit" value="base_unit" {{ $user->type == 'base_unit' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="type">Base Unit</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="type" id="sub_unit" value="sub_unit" {{ $user->type == 'sub_unit' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="type">Sub Unit</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  <div class="row mt-2">
                                        <h5 class="col-md-6">Add Sub Chemical</h5>
                                        <div class="form-group col-md-4">
                                            <label for="metervalue">Meter Value</label>
                                            <input type="text" class="form-control" id="metervalue" name="metervalue"
                                                   value="{{ old('metervalue', $user->metervalue) }}" placeholder="Enter meter value" {{ $user->type == 'base_unit' ? 'readonly' : '' }} />
                                            @error('metervalue')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chemical</label>
                                                <select name="chemical" id="chemical" class="form-control">
                                                    <option value="">Select Chemical</option>
                                                    @foreach ($condition_list as $condition)
                                                        <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>  --}}
                                        {{--  <div class="col-md-6">
                                            <label>Qty</label>
                                            <input type="text" name="qty" id="qty" class="form-control" placeholder="" />
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-sm btn-success mt-2" id="addQuote"> +
                                                Add</button>
                                        </div>  --}}
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
                                        @foreach ($userGet as $item)
                                            <tr>
                                                <td>{{ $item->name }}
                                                    <input type="hidden" name="chemical_id[]" value="{{ $item->chemical_id }}" required /></td>
                                                <td>{{ $item->chemcical_qty }}
                                                    <input type="hidden" name="chemical_qty[]" value="{{ $item->qty }}" required/></td>
                                                <td>{{ $item->chemcical_qty }}/{{ $item->meter_value }}</td>
                                                <td>{{ $item->value }}
                                                    <input type="hidden" name="chemical_calculation[]" value="{{ $item->value }}" required/></td>
                                                <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{--  <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>  --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function(){
            let grandtotal = {{ $userGet->sum('calculation') }};
            $('#addQuote').click(function() {
                var meterValue = $("#metervalue").val();
                var chemical_id = $('#chemical').val();
                var chemical_name = $('#chemical :selected').text();
                var qty = $('#qty').val();
                var meter_value = qty +'/'+ meterValue;
                var calculation = qty / meterValue;
                grandtotal += calculation;

                if (!meterValue) {
                    alert("Please add meter value first!");
                    return;
                }
                $('#quoteTableBody').append(`<tr>
                    <td>` + chemical_name + `<input type="hidden" name="chemical_id[]" value="` + chemical_id + `" required /></td>
                    <td>` + qty + `<input type="hidden" name="chemical_qty[]" value="` + qty + `" required/></td>
                    <td>` + meter_value + `</td>
                    <td>` + calculation + `<input type="hidden" name="chemical_calculation[]" value="` + calculation + `" required/></td>
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
                $(this).closest('tr').remove();
            });

            $('#sub_unit').on('click', function(){
                if($(this).val() === 'sub_unit'){
                    $('#metervalue').prop('required', false);
                    $('#metervalue').prop('readonly', false);
                }
            });

            $('#base_unit').on('click', function(){
                if($(this).val() === 'base_unit'){
                    $('#metervalue').prop('required', true);
                    $('#metervalue').prop('readonly', true);
                }
            });
        });
    </script>
@endsection
