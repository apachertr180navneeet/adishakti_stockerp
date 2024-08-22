@extends('admin.layout.main_app')
@section('title', 'Machine Report')

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
                    <h1 class="m-0">Machine Report</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Machine Report</li>
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
                                    <h3 class="card-title">Machine Report</h3>
                                </div>
                                <div class="col-md-5"></div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('admin.machine.report.filter') }}" method="get">
                                <div class="row mb-2">
                                    <div class="col-md-12 mb-2">
                                        Filter
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label for="from"> Date</label>
                                            <input class="form-control" type="date" name="from" id="from" value="{{ $startDate }}">
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

                            <br>


                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="showhide" id="showhide" value="color" checked>
                                <label class="form-check-label" for="inlineRadio1">Color</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="showhide" id="showhide" value="chemical">
                                <label class="form-check-label" for="inlineRadio2">Chemical</label>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->              
                <div class="col-12" id="exportableContent">
                    <div class="row mb-2">
                    @if (!empty($stock_report))
                        @foreach ($stock_report as $stock_reports)
                            <div class="col-md-3">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <p>Jigar Machine :- {{$stock_reports->machine_name}}</p>
                                        <p>Person Name :- </p>
                                        <p>Date :- {{$stock_reports->excute_date}}</p>
                                        <p>Marka :- {{$stock_reports->marka}}</p>
                                        <div class ="color">
                                            <p class="card-title">Color :- </p>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="row">Name</th>
                                                        <th scope="row">Meter Value</th>
                                                        <th scope="row">Gram</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $stock_report_color = DB::table('stock_meterial_color')
                                                                        ->select('stock_meterial_color.color_id','stock_meterial_color.stock_material_id','color.usage_per_gram','stock_meterial_color.color_item_id','stock_meterial_color.gram','color.color_name','color.meter_value','color.is_group','color.meter_value','color.id as color_ids')
                                                                        ->where('stock_meterial_color.stock_material_id',$stock_reports->id)
                                                                        ->join('color', 'stock_meterial_color.color_item_id', '=', 'color.id')
                                                                        ->get();
                                                        $stock_meterial_consumption = DB::table('stock_meterial_consumption')
                                                                        ->where('stock_meterial_consumption.stock_material_id',$stock_reports->id)
                                                                        ->first();
                                                    @endphp
                                                    @foreach ( $stock_report_color as $stock_report_colors ) 
                                                    @php
                                                    $colorroundedgram = $stock_report_colors->usage_per_gram;
                                                    @endphp
                                                    @php
                                                        $ColorCombination = DB::table('color_combination')
                                                                        ->select('color_combination.color_id','color_combination.name','color_combination.gram')
                                                                        ->where('color_combination.color_id',$stock_report_colors->color_ids)
                                                                        ->get();
                                                    @endphp
                                                    @php
                                                    $colorroundedgramstest = 0;
                                                    @endphp
                                                    @foreach ( $ColorCombination as $ColorCombinations ) 
                                                    @php
                                                    $colorroundedgramstest += $ColorCombinations->gram * $stock_meterial_consumption->qty * 10;
                                                    @endphp
                                                    @endforeach
                                                        <tr>
                                                        <th scope="row">{{$stock_report_colors->color_name}}</th>
                                                        <td>{{$stock_meterial_consumption->qty}} Meter</td>
                                                        <td>{{$colorroundedgramstest}} GM</td>
                                                        </tr>
                                                        <table class="table">
                                                            <tbody>
                                                                
                                                                @foreach ( $ColorCombination as $ColorCombinations ) 
                                                                @php
                                                                $colorroundedgrams = $ColorCombinations->gram * $stock_meterial_consumption->qty * 10;
                                                                @endphp
                                                                    <tr>
                                                                    <th scope="row">{{$ColorCombinations->name}}</th>
                                                                    <td>{{$colorroundedgrams }} GM</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="chemical d-none">
                                            <p class="card-title">Chemical :- </p>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="row">Name</th>
                                                        <th scope="row">Meter Value</th>
                                                        <th scope="row">Gram</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $stock_report_chemical = DB::table('stock_meterial_chemical')
                                                                        ->select('stock_meterial_chemical.chemical_id','stock_meterial_chemical.stock_material_id','stock_meterial_chemical.chemical_item_id','stock_meterial_chemical.rate','stock_meterial_chemical.gram','condition_master.name','condition_master.meter_value','condition_master.id as chemicalids')
                                                                        ->where('stock_meterial_chemical.stock_material_id',$stock_reports->id)
                                                                        ->join('condition_master', 'stock_meterial_chemical.chemical_item_id', '=', 'condition_master.id')
                                                                        ->get();
                                                    @endphp
                                                    @foreach ( $stock_report_chemical as $stock_report_chemicals ) 
                                                    @php
                                                    $chemicalroundedgram = number_format((float)$stock_report_chemicals->gram, 2, '.', '');
                                                    @endphp
                                                        <tr>
                                                        <th scope="row">{{$stock_report_chemicals->name}}</th>
                                                        <td>{{$stock_meterial_consumption->qty}} Meter</td>
                                                        <td>{{$chemicalroundedgram * $stock_meterial_consumption->qty}} GM</td>
                                                        </tr>

                                                        <table class="table">
                                                            <tbody>
                                                                @php
                                                                    $ChemicalCombination = DB::table('chemical_combination')
                                                                                    ->select('chemical_combination.chemical_id','chemical_combination.chemical_item_id','chemical_combination.chemical_id','chemical_combination.chemical_calculation','condition_master.name','unit.unit_code as unit_code')
                                                                                    ->where('chemical_combination.chemical_id',$stock_report_chemicals->chemicalids)
                                                                                    ->join('condition_master', 'chemical_combination.chemical_item_id', '=', 'condition_master.id')
                                                                                    ->join('unit', 'condition_master.unit', '=', 'unit.id')
                                                                                    ->get();
                                                                @endphp
                                                                @foreach ( $ChemicalCombination as $ChemicalCombinations ) 
                                                                @php
                                                                $colorroundedgram = number_format((float)$ChemicalCombinations->chemical_calculation, 2, '.', '');
                                                                @endphp
                                                                    <tr>
                                                                    <th scope="row">{{$ChemicalCombinations->name}}</th>
                                                                    <td>{{$colorroundedgram * $stock_meterial_consumption->qty}} {{$ChemicalCombinations->unit_code}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else    
                        <div class="col-md-3">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <p>Jigar Machine :- No slip Found</p>
                                    </div>
                                </div>
                            </div>
                    @endif
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


    $(document).ready(function(){
        $('input[type="radio"]').change(function(){
            var value = $(this).val();
            if(value == 'chemical'){
                $('.color').addClass('d-none');
                $('.chemical').removeClass('d-none');
            } else {
                $('.chemical').addClass('d-none');
                $('.color').removeClass('d-none');
            }
        });
    });
</script>
@endsection
