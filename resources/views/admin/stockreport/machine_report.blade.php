@extends('admin.layout.main_app')
@section('title', 'Machine Report')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
@section('content')

<style>
    td{
        font-weight: bold;
    }

    hr {
        margin: 1rem 0;
        color: inherit;
        background-color: black;
        border: 0;
      }
    #exportableContent {
        background-color: white !important;
    }    
</style>
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
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label for="branch"> Branch</label>
                                            <select class="form-control" id="branch" name="branch">
                                                @foreach ($branch_list as $branchs)
                                                <option value="{{ $branchs->id }}" @if($branchs->id == $branch) selected @endif>{{ $branchs->name }}</option>
                                                @endforeach
                                            </select>
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
                            <div class="col-md-4">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <p style="font-weight: bold; font-size: 20px">Jigar Machine :- {{$stock_reports->machine_name}}</p>
                                        <p style="font-weight: bold; font-size: 20px">Person Name :- </p>
                                        <p style="font-weight: bold; font-size: 20px">Date :- {{$stock_reports->excute_date}}</p>
                                        <p style="font-weight: bold; font-size: 20px">Marka :- {{$stock_reports->marka}}</p>
                                        <div class ="color">
                                            <p class="card-title" style="font-weight: bold; font-size: 20px">Color :- </p>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="row">Name</th>
                                                        <th scope="row">Meter</th>
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
                                                        <th scope="row" style="font-size: 20px">{{$stock_report_colors->color_name}}</th>
                                                        <td class="fw-bold" style="font-size: 20px">{{$stock_meterial_consumption->qty}} Meter</td>
                                                        <td class="fw-bold" style="font-size: 20px">{{$colorroundedgramstest}} GM</td>
                                                        </tr>
                                                        <table class="table">
                                                            <hr class="border-2 border-top" style="height: 3px; color:black" />
                                                            <tbody>

                                                                @foreach ( $ColorCombination as $ColorCombinations )
                                                                @php
                                                                $colorroundedgrams = $ColorCombinations->gram * $stock_meterial_consumption->qty * 10;
                                                                @endphp
                                                                    <tr>
                                                                    <th scope="row" style="font-size: 20px">{{$ColorCombinations->name}}</th>
                                                                    <td class="fw-bold" style="font-size: 20px">{{$colorroundedgrams }} GM</td>
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
                                                        <th scope="row">Meter</th>
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
                                                        <th scope="row" style="font-size: 20px">{{$stock_report_chemicals->name}}</th>
                                                        <td class="fw-bold" style="font-size: 20px">{{$stock_meterial_consumption->qty}} Meter</td>
                                                        <td class="fw-bold" style="font-size: 20px">{{$chemicalroundedgram * $stock_meterial_consumption->qty}} GM</td>
                                                        </tr>
                                                        <table class="table">
                                                            <hr class="border-2 border-top" style="height: 3px; size: 14px; color:black" />
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
                                                                    <th scope="row" style="font-size: 20px">{{$ChemicalCombinations->name}}</th>
                                                                    <td class="fw-bold" style="font-size: 20px">{{$colorroundedgram * $stock_meterial_consumption->qty}} {{$ChemicalCombinations->unit_code}}</td>
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
<!-- jsPDF Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- jsPDF AutoTable Plugin -->
{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>  --}}

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>



<script type="text/javascript">
    {{--  $("#exportBtn").click(function () {
        setTimeout(function () {
            html2canvas(document.getElementById("exportableContent"), {
                allowTaint: true,
                useCORS: true,
                scale: 2, // High resolution for better clarity
            }).then(function (canvas) {
                var imgWidth = 500; // Width in PDF
                var pageHeight = 842; // A4 page height in points
                var imgHeight = (canvas.height * imgWidth) / canvas.width; // Maintain aspect ratio
                var yOffset = 0;
                var sections = [];
                var tempCanvas = document.createElement("canvas");
                var ctx = tempCanvas.getContext("2d");
    
                tempCanvas.width = canvas.width;
                tempCanvas.height = pageHeight * (canvas.width / imgWidth);
    
                let totalPages = Math.ceil(canvas.height / tempCanvas.height); // Total number of pages
                let pageIndex = 0; // Track current page
    
                // Identify row positions to ensure no row is cut off
                let table = document.getElementById("exportableContent");
                let rows = table.getElementsByTagName("tr");
                let rowPositions = [];
    
                // Collect row positions based on offsetTop
                for (let row of rows) {
                    rowPositions.push({
                        start: row.offsetTop,
                        end: row.offsetTop + row.offsetHeight
                    });
                }
    
                while (yOffset < canvas.height) {
                    let nextOffset = yOffset + tempCanvas.height;
                    let adjustedOffset = yOffset; // To ensure page ends at a full row
    
                    // Find the closest full row boundary
                    for (let i = 0; i < rowPositions.length; i++) {
                        if (rowPositions[i].start >= nextOffset) {
                            adjustedOffset = rowPositions[i - 1]?.end || nextOffset;
                            break;
                        }
                    }
    
                    // Adjust tempCanvas height to end at a full row
                    tempCanvas.height = adjustedOffset - yOffset;
    
                    let sectionPercentage = ((tempCanvas.height / canvas.height) * 100).toFixed(2); // Convert to percentage
    
                    ctx.clearRect(0, 0, tempCanvas.width, tempCanvas.height);
                    ctx.drawImage(
                        canvas,
                        0, yOffset, 
                        canvas.width, tempCanvas.height, 
                        0, 0, 
                        tempCanvas.width, tempCanvas.height
                    );
    
                    sections.push({
                        image: tempCanvas.toDataURL("image/png"),
                        width: imgWidth,
                        margin: [0, 0, 0, 0],
                        pageBreak: pageIndex < totalPages - 1 ? "after" : "" // Page break only if not last page
                    });
    
                    console.log(`Page ${pageIndex + 1}: ${sectionPercentage}% of total content`);
    
                    yOffset = adjustedOffset; // Move to the next full row
                    pageIndex++; // Update page index
                }
    
                var docDefinition = {
                    pageSize: "A4",
                    content: sections,
                };
    
                pdfMake.createPdf(docDefinition).download("Machine_Report.pdf");
            });
        }, 500);
    });      --}}
    
    $(document).ready(function () {
        $("#exportBtn").click(function () {
            const { jsPDF } = window.jspdf;
            let doc = new jsPDF("p", "mm", "a4");
    
            let content = document.getElementById("exportableContent");
    
            html2canvas(content, {
                backgroundColor: null,
                scale: 2,
                useCORS: true
            }).then((canvas) => {
                let imgData = canvas.toDataURL("image/png");
                let imgWidth = 190;
                let pageHeight = 297; // A4 height in mm
                let imgHeight = (canvas.height * imgWidth) / canvas.width;
                let position = 10;
                let heightLeft = imgHeight;
    
                doc.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
                heightLeft -= pageHeight - position;
    
                let currentPage = 1;
                while (heightLeft > 0) {
                    doc.addPage();
                    position = 10;
                    let offset = (currentPage * (pageHeight - position) * canvas.height) / imgHeight;
                    
                    let croppedCanvas = cropCanvas(canvas, offset, canvas.width, (pageHeight * canvas.height) / imgHeight);
                    let croppedImgData = croppedCanvas.toDataURL("image/png");
                    let croppedImgHeight = (croppedCanvas.height * imgWidth) / croppedCanvas.width;
    
                    doc.addImage(croppedImgData, "PNG", 10, position, imgWidth, croppedImgHeight);
                    heightLeft -= pageHeight;
    
                    currentPage++;
                }
    
                doc.save("machine_report.pdf");
            });
        });
    
        // Function to crop the canvas correctly
        function cropCanvas(canvas, startY, width, height) {
            let croppedCanvas = document.createElement("canvas");
            croppedCanvas.width = width;
            croppedCanvas.height = height;
            let ctx = croppedCanvas.getContext("2d");
    
            ctx.drawImage(canvas, 0, startY, width, height, 0, 0, width, height);
            return croppedCanvas;
        }
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
