@extends('admin.layout.main_app')
@section('title', 'Machine Edit')
@section('content')
            <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Machine Edit</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Machine Edit</li>
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
                        <form role="form" action="{{ route('admin.machine.update') }}" method="post" id="coustomer_add" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $machine->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Machine</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $machine->name }}" placeholder="Enter item" required/>
                                </div>
                                <div class="form-group">
                                    <label for="code">Machine code</label>
                                    <input type="text" class="form-control" id="code" name="code" value="{{ $machine->code }}" placeholder="Enter machine" required/>
                                </div>
                                <div class="form-group">
                                    <label for="last_repair_date">Last Reapir Date</label>
                                    <input type="date" class="form-control" id="last_repair_date" name="last_repair_date" value="{{ $machine->last_repair_date }}" placeholder="Enter machine" required/>
                                </div>
                                <div class="form-group">
                                    <label for="description">Machine Description</label>
                                    <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter ...">{{ $machine->description }}</textarea>
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

@endsection
