@extends('admin.layout.main_app')
@section('title', 'Batch Add')
@section('content')
            <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Batch Add</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-Batch"><a href="#">Home</a>/</li>
                        <li class="breadcrumb-Batch active">Batch Add</li>
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
                        <form role="form" action="{{ route('admin.batch.store') }}" method="post" id="coustomer_add" enctype="multipart/form-data">
                        @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Machine Number</label>
                                    <select class="form-control select2bs4 select2-hidden-accessible" name="machine_number" style="width: 100%;" aria-hidden="true" required>
                                        <option value="">----Select----</option>
                                        @foreach ($machine_list as $machine)
                                        <option value="{{ $machine->id }}">{{ $machine->code }}({{ $machine->name }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="batch_name">Name</label>
                                    <input type="text" class="form-control" id="batch_name" name="batch_name" value="{{ old('batch_name') }}" placeholder="Enter Batch" required/>
                                    @error('Batch')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="batch_code">Batch code</label>
                                    <input type="text" class="form-control" id="batch_code" name="batch_code" value="{{ old('batch_code') }}" placeholder="Enter Batch Code" required/>
                                    @error('Batch')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="date_of_mgf">Date of manufacturing</label>
                                    <input type="date" class="form-control" id="date_of_mgf" name="date_of_mgf" value="{{ old('date_of_mgf') }}" placeholder="" required/>
                                    @error('Batch')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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

@endsection
