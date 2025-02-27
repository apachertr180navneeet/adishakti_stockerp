<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machine Report</title>

    <!-- Custom Styles (Optimized for DomPDF) -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
        }

        .container {
            width: 100%;
        }

        .row {
            width: 100%;
            display: block;
            overflow: hidden; /* Ensures proper wrapping */
            page-break-inside: avoid;
        }

        .card {
            width: 30%; /* Adjust for 3 cards per row */
            border: 1px solid black;
            /*padding: 10px;*/
            box-sizing: border-box;
            display: inline-block;
            vertical-align: top;
            margin: 5px 1%; /* Space between cards */
            page-break-inside: avoid;
        }        

        .card p {
            font-weight: bold;
            font-size: 14px;
            margin: 5px 0;
        }

        .table {
            width: 100%;
            margin-top: 5px;
            table-layout: fixed; /* Ensures consistent column width */
        }
        
        .table th, .table td {
            font-size: 12px;
            line-height: 9px;
        }        

        .border-line {
            margin: 5px 0;
        }

        /* Ensure last element in row does not float */
        .row::after {
            content: "";
            display: table;
            clear: both;
        }

        

    </style>
</head>
<body>

    <div class="container">
        @if (!empty($stock_report))
            @php $count = 0; @endphp
            @foreach ($stock_report as $stock_reports)
                @if ($count % 3 == 0)
                    <div class="row">
                @endif

                <div class="card">
                    <p>Jigar Machine: {{ $stock_reports->machine_name }}</p>
                    <p>Person Name: ___________</p> <!-- If no data for person name -->
                    <p>Date: {{ $stock_reports->excute_date }}</p>
                    <p>Marka: {{ $stock_reports->marka }}</p>

                    @if ($showhide == 'color')
                        <div class="color">
                            <p>Color Details:</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Meter</th>
                                        <th>Gram</th>
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
                                        <th style="line-height: 18px;">{{$stock_report_colors->color_name}}</th>
                                        <td class="fw-bold" style="line-height: 18px;">{{$stock_meterial_consumption->qty}} Meter</td>
                                        <td class="fw-bold" style="line-height: 18px;">{{$colorroundedgramstest}} GM</td>
                                        </tr>
                                        <table style="width: 100%;">
                                            <tbody>

                                                @foreach ( $ColorCombination as $ColorCombinations )
                                                @php
                                                $colorroundedgrams = $ColorCombinations->gram * $stock_meterial_consumption->qty * 10;
                                                @endphp
                                                    <tr>
                                                    <th style="width: 50%; font-size: 12px; line-height: 18px;">{{$ColorCombinations->name}}</th>
                                                    <td class="fw-bold" style="width: 50%; font-size: 12px; line-height: 18px;">{{$colorroundedgrams }} GM</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="chemical">
                            <p>Chemical Details:</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Meter</th>
                                        <th>Gram</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $stock_report_chemical = DB::table('stock_meterial_chemical')
                                                        ->select('stock_meterial_chemical.chemical_id','stock_meterial_chemical.stock_material_id','stock_meterial_chemical.chemical_item_id','stock_meterial_chemical.rate','stock_meterial_chemical.gram','condition_master.name','condition_master.meter_value','condition_master.id as chemicalids')
                                                        ->where('stock_meterial_chemical.stock_material_id',$stock_reports->id)
                                                        ->join('condition_master', 'stock_meterial_chemical.chemical_item_id', '=', 'condition_master.id')
                                                        ->get();
                                        $stock_meterial_consumption = DB::table('stock_meterial_consumption')
                                                        ->where('stock_meterial_consumption.stock_material_id',$stock_reports->id)
                                                        ->first();
                                    @endphp
                                    @foreach ( $stock_report_chemical as $stock_report_chemicals )
                                    @php
                                    $chemicalroundedgram = number_format((float)$stock_report_chemicals->gram, 2, '.', '');
                                    @endphp
                                        <tr>
                                        <th scope="row" style="line-height: 18px;">{{$stock_report_chemicals->name}}</th>
                                        <td class="fw-bold" style="line-height: 18px;">{{$stock_meterial_consumption->qty}} Meter</td>
                                        <td class="fw-bold" style="line-height: 18px;">{{$chemicalroundedgram * $stock_meterial_consumption->qty}} GM</td>
                                        </tr>
                                        <table style="width: 100%; margin: 0%">
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
                                                    <th style="width: 50%; font-size: 12px; line-height: 18px;">{{$ChemicalCombinations->name}}</th>
                                                    <td class="fw-bold" style="width: 50%; font-size: 12px; line-height: 18px;">{{$colorroundedgram * $stock_meterial_consumption->qty}} {{$ChemicalCombinations->unit_code}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                @php $count++; @endphp

                @if ($count % 3 == 0)
                    </div> <!-- Close row -->
                @endif
            @endforeach

            <!-- Close any open row -->
            @if ($count % 3 != 0)
                </div>
            @endif
        @else
            <p>No Data Available</p>
        @endif
    </div>
</body>
</html>
