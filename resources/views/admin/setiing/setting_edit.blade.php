@extends('admin.layout.main_app')
@section('title', 'Setting Edit')
@section('content')
            <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Setting Edit</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Setting Edit</li>
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
                        <form role="form" action="{{ route('admin.setting.edit') }}" method="post" id="coustomer_Edit" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="id" value="{{ $settingdata->id }}" >
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $settingdata->title }}" placeholder="Enter title" />
                                </div>
                                <div class="form-group">
                                    <label for="link">App Link</label>
                                    <input type="text" class="form-control" id="link" name="app_link" value="{{ $settingdata->app_link }}" placeholder="Enter link" />
                                </div>
                                <div class="form-group">
                                    <label for="vedio">Vedio File</label>
                                    <input type="file" class="form-control" id="vedio" name="vedio" value="{{ $settingdata->vedio }}" placeholder="Uplload vedio" />
                                </div>
                                <div class="form-group">
                                    <label for="app_logo">App Logo File</label>
                                    <input type="file" class="form-control" id="app_logo" name="app_logo" value="{{ $settingdata->app_link }}" placeholder="Uplload App Logo" />
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
