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
                            <h3 class="card-title">Color Add</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('admin.color.store') }}" method="post" id="coustomer_add" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="color_name">Color Name</label>
                                    <input type="text" class="form-control" id="color_name" name="color_name" value="{{ old('color_name') }}" placeholder="Enter Name" required/>
                                    @error('color_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="color_code">Color Code</label>
                                    <input type="text" class="form-control" id="color_code" name="color_code" value="{{ old('color_code') }}" placeholder="Enter Code" required/>
                                    @error('color_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="rate_per_gram">Rate per Meter</label>
                                    <input type="text" class="form-control" id="rate_per_gram" name="rate_per_gram" value="{{ old('rate_per_gram') }}" placeholder="Enter Rate Per Meter" required/>
                                    @error('rate_per_gram')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Color Combination</label>
                                </div>
                                <div class="row">
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
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-sm btn-success mt-2" id="addQuote"> +
                                            Add</button>
                                    </div>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td width="12%">Color</td>
                                            <td width="8%">GM</td>
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
            $('#addQuote').click(function() {
                var combination_colorname = $('#combination_color').val();
                var combination_colorname = $('#combination_color :selected').text();
                var combination_gm = $('#combination_gm').val();

                $('#quoteTableBody').append(`<tr>
                                            <td>` + combination_colorname +
                    `<input type="hidden" name="name[]" value="` + combination_colorname + `" required /></td>
                                            <td>` + combination_gm + `<input type="hidden" name="gm[]" value="` +
                                                combination_gm + `" required/></td>
                                            <td><button type="button" class="btn btn-danger remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                        </tr>`);
                $('#combination_color').val('');
                $('#combination_gm').val('');
            });
        });


        $(document).on('click', '.remove-row', function() {
            (this).closest('tr').remove();
        });
</script>
@endsection
