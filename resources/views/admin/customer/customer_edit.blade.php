@extends('admin.layout.main_app')
@section('title', 'Customer Edit')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customer Edit</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Customer Edit</li>
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
                            <form role="form" action="{{ route('admin.customer.update') }}" method="post"
                                id="coustomer_add" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Customer Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" placeholder="Enter Name" required />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            value="{{ $user->phone_number }}" placeholder="Enter Phone" required />
                                        @error('phone_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}" placeholder="Enter email" required />
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="{{ $user->address }}" placeholder="Enter Address" required />
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            value="{{ $user->city }}" placeholder="Enter City" required />
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" class="form-control" id="state" name="state"
                                            value="{{ $user->state }}" placeholder="Enter State" required />
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pincode">Pincode</label>
                                        <input type="text" class="form-control" id="pincode" name="pincode"
                                            value="{{ $user->pincode }}" placeholder="Enter Pincode" required />
                                        @error('pincode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pincode">GST Number</label>
                                        <input type="text" class="form-control" id="gst_number" name="gst_number"
                                            value="{{ $user->gst_number }}" placeholder="Enter GST Number" required />
                                        @error('gst_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="profileimage">Profile Image</label>
                                        <input type="file" class="form-control" id="profileimage"
                                            name="profileimage" />
                                    </div>
                                    {{--  <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="1" {{ $user->gender == '1' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="2" {{ $user->gender == '2' ? 'selected' : '' }}>Female
                                            </option>
                                        </select>
                                    </div>  --}}
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
