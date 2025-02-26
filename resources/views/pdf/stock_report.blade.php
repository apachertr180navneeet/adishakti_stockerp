<style>
    @media print {
        .page-break {
            page-break-before: always;
            break-before: page;
        }
        
        .row-container {
            display: block !important; /* Fix flex issue in print mode */
        }

        .card-group {
            display: block !important; /* Prevents flex wrapping issues */
        }

        .stock-card {
            width: 100%; /* Ensure each card takes full width to prevent splitting */
            border: 1px solid black;
            box-sizing: border-box;
            page-break-inside: avoid;
            break-inside: avoid;
            padding: 10px;
            margin-bottom: 10px;
        }
    }

    .row-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    .stock-card {
        width: 30%;
        border: 1px solid black;
        box-sizing: border-box;
        display: inline-block;
        vertical-align: top;
        margin-bottom: 10px;
    }
</style>


<div class="col-12" id="exportableContent">
    <div class="row-container mb-2">
        @if (!empty($stock_report))
            @foreach ($stock_report->chunk(3) as $stock_report_chunk) <!-- Group by 3 -->
                <div class="card-group">
                    @foreach ($stock_report_chunk as $stock_reports)
                        <div class="stock-card">
                            <div class="card">
                                <div class="card-body">
                                    <p @if ($showhide == 'color') style="font-weight: bold; font-size: 10px" @else style="font-weight: bold; font-size: 14px" @endif>Jigar Machine :- {{ $stock_reports->machine_name }}</p>
                                    <p @if ($showhide == 'color') style="font-weight: bold; font-size: 10px" @else style="font-weight: bold; font-size: 14px" @endif>Person Name :- </p>
                                    <p @if ($showhide == 'color') style="font-weight: bold; font-size: 10px" @else style="font-weight: bold; font-size: 14px" @endif>Date :- {{ $stock_reports->excute_date }}</p>
                                    <p @if ($showhide == 'color') style="font-weight: bold; font-size: 10px" @else style="font-weight: bold; font-size: 14px" @endif>Marka :- {{ $stock_reports->marka }}</p>

                                    <!-- Color Section -->
                                    <div class="color" @if ($showhide == 'chemical') style="display: none;" @endif>
                                        <p class="card-title" style="font-weight: bold; font-size: 10px">Color :- </p>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 10px">Name</th>
                                                    <th style="font-size: 10px">Meter</th>
                                                    <th style="font-size: 10px">Gram</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $stock_report_color = DB::table('stock_meterial_color')
                                                        ->select('stock_meterial_color.color_id', 'stock_meterial_color.stock_material_id', 'color.usage_per_gram', 'stock_meterial_color.color_item_id', 'stock_meterial_color.gram', 'color.color_name', 'color.meter_value', 'color.is_group', 'color.id as color_ids')
                                                        ->where('stock_meterial_color.stock_material_id', $stock_reports->id)
                                                        ->join('color', 'stock_meterial_color.color_item_id', '=', 'color.id')
                                                        ->get();

                                                    $stock_meterial_consumption = DB::table('stock_meterial_consumption')
                                                        ->where('stock_meterial_consumption.stock_material_id', $stock_reports->id)
                                                        ->first();
                                                @endphp

                                                @foreach ($stock_report_color as $stock_report_colors)
                                                    @php
                                                        $colorroundedgramstest = DB::table('color_combination')
                                                            ->where('color_id', $stock_report_colors->color_ids)
                                                            ->sum(DB::raw('gram * ' . $stock_meterial_consumption->qty . ' * 10'));
                                                    @endphp

                                                    <tr>
                                                        <th style="font-size: 10px">{{ $stock_report_colors->color_name }}</th>
                                                        <td class="fw-bold" style="font-size: 10px">{{ $stock_meterial_consumption->qty }} Meter</td>
                                                        <td class="fw-bold" style="font-size: 10px">{{ $colorroundedgramstest }} GM</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3">
                                                            <table class="table">
                                                                <tbody>
                                                                    @php
                                                                        $ColorCombination = DB::table('color_combination')
                                                                            ->where('color_id', $stock_report_colors->color_ids)
                                                                            ->get();
                                                                    @endphp

                                                                    @foreach ($ColorCombination as $ColorCombinations)
                                                                        <tr>
                                                                            <th style="font-size: 10px">{{ $ColorCombinations->name }}</th>
                                                                            <td class="fw-bold" style="font-size: 10px">{{ $ColorCombinations->gram * $stock_meterial_consumption->qty * 10 }} GM</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Chemical Section -->
                                    <div class="chemical" @if ($showhide == 'color') style="display: none;" @endif>
                                        <p class="card-title">Chemical :- </p>
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
                                                        ->select('stock_meterial_chemical.chemical_id', 'stock_meterial_chemical.stock_material_id', 'stock_meterial_chemical.chemical_item_id', 'stock_meterial_chemical.rate', 'stock_meterial_chemical.gram', 'condition_master.name', 'condition_master.meter_value', 'condition_master.id as chemicalids')
                                                        ->where('stock_meterial_chemical.stock_material_id', $stock_reports->id)
                                                        ->join('condition_master', 'stock_meterial_chemical.chemical_item_id', '=', 'condition_master.id')
                                                        ->get();
                                                @endphp

                                                @foreach ($stock_report_chemical as $stock_report_chemicals)
                                                    <tr>
                                                        <th style="font-size: 14px">{{ $stock_report_chemicals->name }}</th>
                                                        <td class="fw-bold" style="font-size: 14px">{{ $stock_meterial_consumption->qty }} Meter</td>
                                                        <td class="fw-bold" style="font-size: 14px">{{ number_format($stock_report_chemicals->gram * $stock_meterial_consumption->qty, 2, '.', '') }} GM</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3">
                                                            <table class="table">
                                                                <tbody>
                                                                    @php
                                                                        $ChemicalCombination = DB::table('chemical_combination')
                                                                            ->where('chemical_id', $stock_report_chemicals->chemicalids)
                                                                            ->join('condition_master', 'chemical_combination.chemical_item_id', '=', 'condition_master.id')
                                                                            ->join('unit', 'condition_master.unit', '=', 'unit.id')
                                                                            ->get();
                                                                    @endphp

                                                                    @foreach ($ChemicalCombination as $ChemicalCombinations)
                                                                        <tr>
                                                                            <th style="font-size: 14px">{{ $ChemicalCombinations->name }}</th>
                                                                            <td class="fw-bold" style="font-size: 14px">
                                                                                {{ number_format($ChemicalCombinations->chemical_calculation * $stock_meterial_consumption->qty, 2, '.', '') }}
                                                                                {{ $ChemicalCombinations->unit_code }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="page-break"></div> <!-- Breaks after every 3 cards -->
            @endforeach
        @else
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p>Jigar Machine :- No slip Found</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

