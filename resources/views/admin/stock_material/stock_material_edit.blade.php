@extends('admin.layout.main_app')
@section('title', 'Stock material View')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stock Material View</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Stock Material View</li>
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
                                                                                                                                                                                                                                                                                                                                                                                                    <h3 class="card-title">Overhead Detail</h3>
                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="" method="post" id="coustomer_add"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="stock_material_managemnt_date">Date</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->stock_material_managemnt_date }}" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label for="source_location">Source Location</label>
                                        <input type="text" class="form-control" value="{{ $user->sourcebranchname }}"
                                            readonly />
                                    </div>
                                    <div class="form-group">
                                        <label for="destination_location">Destination Location</label>
                                        <input type="text" class="form-control" value="{{ $user->destinbranchname }}"
                                            readonly />
                                    </div>
                                    <h5>Consumption</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td width="12%">Item</td>
                                                <td width="8%">Rate</td>
                                                <td width="8%">QTY</td>
                                                <td width="12%">Total Amount</td>
                                            </tr>
                                        </thead>
                                        <tbody id="consumption">
                                            @foreach ($stockconsumptionitem as $consumptionitem)
                                                <tr>
                                                    <td>{{ $consumptionitem->item_name }}</td>
                                                    <td>{{ $consumptionitem->rate }}</td>
                                                    <td>{{ $consumptionitem->qty }}</td>
                                                    <td>{{ $consumptionitem->total_amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">

                                            </div>
                                            <div class="col">
                                                <p>Consumption Item Total Amount</p>
                                            </div>
                                            <?php
                                            $consumptiontotal = 0;
                                            
                                            foreach ($stockconsumptionitem as $consumptionitemtotal) {
                                                $consumptiontotal += $consumptionitemtotal->total_amount;
                                            }
                                            ?>
                                            <div class="col">
                                                <input type="input" class="form-control"
                                                    id="consumption_total_item_amount" name="consumption_total_item_amount"
                                                    value="{{ $consumptiontotal }}" placeholder="Final Total Amount"
                                                    readonly />
                                            </div>
                                            <div class="col">

                                            </div>
                                        </div>
                                    </div>
                                    <h6>OverHead</h6>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td width="12%">OverHead Item</td>
                                                <td width="12%">OverHead Total Amount</td>
                                            </tr>
                                        </thead>
                                        <tbody id="overhead">
                                            @foreach ($stockoverhead as $overhead)
                                                <tr>
                                                    <td>{{ $overhead->name }}</td>
                                                    <td>{{ $overhead->amount }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <hr>
                                    <h5>Production</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td width="12%">Item</td>
                                                <td width="8%">Rate</td>
                                                <td width="8%">QTY</td>
                                                <td width="12%">Total Amount</td>
                                            </tr>
                                        </thead>
                                        <tbody id="production">
                                            @foreach ($stockproductionitem as $productionitem)
                                                <tr>
                                                    <td>{{ $productionitem->item_name }}</td>
                                                    <td>{{ $productionitem->rate }}</td>
                                                    <td>{{ $productionitem->qty }}</td>
                                                    <td>{{ $productionitem->total_amount }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">

                                            </div>
                                            <div class="col">

                                            </div>
                                            <div class="col">
                                                <p>Production Total Amount</p>
                                            </div>
                                            <?php
                                            $productiontotal = 0;
                                            
                                            foreach ($stockproductionitem as $productionitemtotal) {
                                                $productiontotal += $productionitemtotal->total_amount;
                                            }
                                            ?>
                                            <div class="col">
                                                <input type="input" class="form-control" id="production_total_amount"
                                                    name="production_total_amount" value="{{ $productiontotal }}"
                                                    placeholder="Final Total Amount" readonly />
                                            </div>
                                            <div class="col">

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">

                                            </div>
                                            <div class="col">

                                            </div>
                                            <div class="col">
                                               <p>Consumption Item Total Amount</p>
                                            </div>
                                            <?php
                                            $consumptiontotal = 0;
                                            
                                            foreach ($stockconsumptionitem as $consumptionitemtotal) {
                                                $consumptiontotal += $consumptionitemtotal->total_amount;
                                            }
                                            ?>
                                            <div class="col">
                                                <input type="input" class="form-control"
                                                    id="consumption_total_item_amount" name="consumption_total_item_amount"
                                                    value="{{ $consumptiontotal }}" placeholder="Final Total Amount"
                                                    readonly />
                                            </div>
                                            <div class="col">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">

                                            </div>
                                            <div class="col">

                                            </div>
                                            <div class="col">
                                                Overhead Total Amount
                                            </div>
                                            <?php
                                            $overheadtotaltotal = 0;
                                            
                                            foreach ($stockoverhead as $overheadtotal) {
                                                $overheadtotaltotal += $overheadtotal->amount;
                                            }
                                            ?>
                                            <div class="col">
                                                <input type="input" class="form-control" id="overhead_total_amount"
                                                    name="overhead_total_amount" value="{{ $overheadtotaltotal }}"
                                                    placeholder="Final Total Amount" readonly />
                                            </div>
                                            <div class="col">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="row">
                                            <div class="col">

                                            </div>
                                            <div class="col">

                                            </div>
                                            <div class="col">
                                                Consumption Total Amount
                                            </div>
                                            <div class="col">
                                                <input type="input" class="form-control" id="consuption_total_amount"
                                                    name="consuption_total_amount" value="{{ $consumptiontotal + $overheadtotaltotal }}"
                                                    placeholder="Final Total Amount" readonly />
                                            </div>
                                            <div class="col">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        {{-- <button type="submit" class="btn btn-primary saveMaterial">Save</button> --}}
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
