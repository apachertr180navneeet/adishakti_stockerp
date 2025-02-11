<!DOCTYPE html>
<html>
<head>
    <title>Stock Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .title { font-size: 22px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Stock Report</h2>

    @foreach ($stock_report as $report)
        <p class="title">Jigar Machine: {{ $report->machine_name }}</p>
        <p class="title">Date: {{ $report->excute_date }}</p>
        <p class="title">Marka: {{ $report->marka }}</p>

        <h3>Colors</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Meter</th>
                <th>Gram</th>
            </tr>
            @php
                $colors = DB::table('stock_meterial_color')
                    ->join('color', 'stock_meterial_color.color_item_id', '=', 'color.id')
                    ->where('stock_meterial_color.stock_material_id', $report->id)
                    ->get();
            @endphp
            @foreach ($colors as $color)
                <tr>
                    <td>{{ $color->color_name }}</td>
                    <td>{{ $color->meter_value }} Meter</td>
                    <td>{{ $color->gram }} GM</td>
                </tr>
            @endforeach
        </table>

        <h3>Chemicals</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Meter</th>
                <th>Gram</th>
            </tr>
            @php
                $chemicals = DB::table('stock_meterial_chemical')
                    ->join('condition_master', 'stock_meterial_chemical.chemical_item_id', '=', 'condition_master.id')
                    ->where('stock_meterial_chemical.stock_material_id', $report->id)
                    ->get();
            @endphp
            @foreach ($chemicals as $chemical)
                <tr>
                    <td>{{ $chemical->name }}</td>
                    <td>{{ $chemical->meter_value }} Meter</td>
                    <td>{{ $chemical->gram }} GM</td>
                </tr>
            @endforeach
        </table>
        <hr>
    @endforeach
</body>
</html>
