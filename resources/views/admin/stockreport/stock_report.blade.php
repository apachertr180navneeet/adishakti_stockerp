@extends('admin.layout.main_app')
@section('title', 'Current Stock Report')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stock Report</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Stock Report</li>
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
                                    <h3 class="card-title">Current Stock Report</h3>
                                </div>
                                <div class="col-md-5"></div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('admin.total.stock.report.filter') }}" method="get">
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        Filter by Stock
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <label for="branch">Company</label>
                                            <select class="form-control" id="branch" name="branch">
                                                @foreach ($branch_list as $branchs)
                                                <option value="{{ $branchs->id }}" @if($branchs->id == $branch) selected @endif>{{ $branchs->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="from">From date</label>
                                            <input class="form-control" type="date" name="from" id="from" value="{{ $startDate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="to">To date</label>
                                            <input class="form-control" type="date" name="to" id="to" value="{{ $endDate }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row mb-2">
                                <div class="col-md-1 mb-2">
                                    <button type="submit" id="exportBtn" class="btn btn-block btn-success">PDF</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-12" id="exportableContent">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-12 text-center">
                                    <h4>@foreach ($branch_list as $branchs)
                                        @if($branchs->id == $branch)
                                            {{ $branchs->name }}
                                        @endif
                                    @endforeach | Current Stock Report</h4>
                                    <p>Date :- {{ $startDate }} - {{ $endDate }} </p>
                                    <p>
                                        Company :-
                                        @foreach ($branch_list as $branchs)
                                            @if($branchs->id == $branch)
                                                {{ $branchs->name }}
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <table id="customer_list" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Branch Name</th>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                {{-- <th>Stock Out</th> --}}
                                                <th>Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($stock_report as $report)
                                            <tr>
                                                <td>{{ $report->branch_name }}</td>
                                                <td>{{ $report->item_name }}</td>
                                                <td>{{ $report->quantity }}</td>
                                                {{-- <td>
                                                    @php
                                                        $stockoutqty = DB::table('stock_meterial_consumption')
                                                        ->select('stock_meterial_consumption.counsumption_item_id','stock_meterial_consumption.qty')
                                                        ->where('stock_meterial_consumption.counsumption_item_id',$report->item_id)
                                                        ->sum('stock_meterial_consumption.qty');

                                                        echo $stockoutqty
                                                    @endphp 
                                                </td> --}}
                                                <td>{{ $report->unit_name}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


<script type="text/javascript">
    $("body").on("click", "#exportBtn", function () {
        html2canvas($('#exportableContent')[0], {
            onrendered: function (canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500
                    }]
                };
                pdfMake.createPdf(docDefinition).download("stock_report.pdf");
            }
        });
    });
</script>
@endsection
