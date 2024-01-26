@extends('admin.layout.main_app')
@section('title', 'Credit Note List')
@section('content')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Credit Note List</h1>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Credit Note List</li>
                                </ol>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content-header -->
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3 class="card-title">Credit Note List</h3>
                                            </div>
                                            <div class="col-md-5">
                                            </div>
                                            <div class="col-md-1">
                                                <a href="{{ route('admin.credit.note.add') }}" class="btn btn-block btn-primary"><i class="fas fa-plus"></i> Add</a>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.credit.note.serach') }}" method="get">
                                        <div class="row ml-3">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>Start Date:</label>
                                                    <div class="input-group">
                                                        <input type="date" name="startDate" value="{{$startDate}}" class="form-control float-right"  required/>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label>End Date:</label>
                                                    <div class="input-group">
                                                        <input type="date" name="endDate" value="{{$endDate}}" class="form-control float-right" required />
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary mt-4">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="customer_list" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Credit Note</th>
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                    <th>Branch/Customer</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                 @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($CreditNoteList as $creditnote)
                                                <tr>
                                                    <td>{{ $creditnote->credit_note }}</td>
                                                    <td>{{ $creditnote->credit_date }}</td>
                                                    <td> 
                                                        @if($creditnote->type==1)
                                                            <p>Branch</p>
                                                        @else
                                                            <p>Customer</p>
                                                        @endif
                                                    </td>
                                                    <td> 
                                                        @if($creditnote->type =='1')
                                                             @php
                                                                $branchto = DB::table('branch')->where('id', '=', $creditnote->branch_id)->first();
                                                                $sendTo = $branchto->name;
                                                            @endphp
                                                        @else
                                                            @php
                                                                $coustomer = DB::table('users')->where('id', '=', $creditnote->user_id)->first();
                                                                $sendTo = $coustomer->name;
                                                            @endphp
                                                        @endif
                                                        {{$sendTo}}
                                                    </td>
                                                    <td>
                                                        @if($creditnote->status =='1')
                                                            <p>Active</p>
                                                        @else
                                                            <p>InActive</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.credit.note.edit',$creditnote->id) }}" class="btn btn-warning">Edit</a>
                                                        <a href="javascript:void(0)" id="delete-user" data-id="{{ $creditnote->id }}" data-url="{{ route('admin.credit.note.delete',$creditnote->id) }}"  class="btn btn-danger delete">Delete</a>
                                                        @if($creditnote->status =='0')
                                                            <a href="javascript:void(0)" data-id="{{ $creditnote->id }}" data-status="1" data-url="{{ route('admin.credit.note.status',$creditnote->id) }}" class="btn btn-success status">Active</a>
                                                        @else
                                                            <a href="javascript:void(0)" data-id="{{ $creditnote->id }}" data-status="0" data-url="{{ route('admin.credit.note.status',$creditnote->id) }}" class="btn btn-danger status">InActive</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-center">
                                            {!! $CreditNoteList->links() !!}
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
@endsection
