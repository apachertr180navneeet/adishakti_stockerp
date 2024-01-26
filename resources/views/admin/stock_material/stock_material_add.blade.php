@extends('admin.layout.main_app') @section('title', 'Stock Material Add') @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stock Material Add</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Stock Material Add</li>
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
                        <!-- form start -->
                        <form role="form" action="{{ route('admin.stock.material.store') }}" method="post"
                            id="coustomer_add" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="stock_material_managemnt_date">Date</label>
                                    <input type="date" class="form-control" id="stock_material_managemnt_date"
                                        name="stock_material_managemnt_date"
                                        value="{{ old('stock_material_managemnt_date') }}" placeholder="Enter Date" />
                                    @error('stock_material_managemnt_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="source_location">Source Location</label>
                                    <select class="form-control select2bs4 select2-hidden-accessible"
                                        id="source_location" name="source_location" style="width: 100%;"
                                        aria-hidden="true" required>
                                        @foreach ($branch_list as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="destination_location">Destination Location</label>
                                    <select class="form-control select2bs4 select2-hidden-accessible"
                                        id="destination_location" name="destination_location" style="width: 100%;"
                                        aria-hidden="true" required>
                                        @foreach ($branch_list as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <h5>Consumption</h5>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control select2bs4 select2-hidden-accessible"
                                                id="consumption_item_id" name="consumption_item_id" style="width: 100%;"
                                                aria-hidden="true">
                                                @foreach ($item_list as $item)
                                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="0" class="form-control"
                                                placeholder="Quantity" name="consumption_qty" id="consumption_qty" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="0" class="form-control" placeholder="Rate"
                                                name="consumption_amount" id="consumption_amount" />
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <button type="button" class="btn btn-sm btn-success" id="addConsumption">+
                                                Add</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td width="5%">SN</td>
                                            <td width="12%">Item</td>
                                            <td width="8%">Rate</td>
                                            <td width="8%">QTY</td>
                                            <td width="12%">Total Amount</td>
                                            <td width="8%">Remove</td>
                                        </tr>
                                    </thead>
                                    <tbody id="consumption">
                                        <!-- Quotation rows will be added here -->
                                    </tbody>
                                </table>

                                <br>
                                <h6>Color</h6>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control select2bs4 select2-hidden-accessible"
                                                id="color_id" name="color_id" style="width: 100%;"
                                                aria-hidden="true">
                                                @foreach ($color_list as $color)
                                                    <option value="{{ $color->id }}">{{ $color->color_name }}({{ $color->color_code }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" min="0" class="form-control"
                                                placeholder="Amount" name="color_amount" id="color_amount" />
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <button type="button" class="btn btn-sm btn-success" id="addColor">+
                                                Add</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td width="5%">SN</td>
                                            <td width="12%">Color Item</td>
                                            <td width="12%">Color Gram</td>
                                            <td width="8%">Remove</td>
                                        </tr>
                                    </thead>
                                    <tbody id="color">
                                        <!-- Quotation rows will be added here -->
                                    </tbody>
                                </table>
                                <br>
                                <h6>OverHead</h6>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control select2bs4 select2-hidden-accessible"
                                                id="overhead_id" name="overhead_id" style="width: 100%;"
                                                aria-hidden="true">
                                                @foreach ($overHeadList as $overhead)
                                                    <option value="{{ $overhead->id }}">{{ $overhead->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" min="0" class="form-control"
                                                placeholder="Amount" name="overhead_amount" id="overhead_amount" />
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <button type="button" class="btn btn-sm btn-success" id="addOverHead">+
                                                Add</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td width="5%">SN</td>
                                            <td width="12%">OverHead Item</td>
                                            <td width="12%">OverHead Total Amount</td>
                                            <td width="8%">Remove</td>
                                        </tr>
                                    </thead>
                                    <tbody id="overhead">
                                        <!-- Quotation rows will be added here -->
                                    </tbody>
                                </table>
                                <hr />
                                <h5>Production</h5>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control select2bs4 select2-hidden-accessible"
                                                id="production_item_id" name="production_item_id"
                                                style="width: 100%;" aria-hidden="true">
                                                @foreach ($item_list as $item)
                                                    <option value="{{ $item->id }}">{{ $item->item_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="0" class="form-control"
                                                placeholder="Quantity" name="production_qty" id="production_qty" />
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="0" class="form-control"
                                                placeholder="Rate" name="production_amount" id="production_amount" />
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <button type="button" class="btn btn-sm btn-success" id="addProduction">
                                                +Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td width="5%">SN</td>
                                            <td width="12%">Item</td>
                                            <td width="8%">Rate</td>
                                            <td width="8%">QTY</td>
                                            <td width="12%">Total Amount</td>
                                            <td width="8%">Remove</td>
                                        </tr>
                                    </thead>
                                    <tbody id="production">
                                        <!-- Quotation rows will be added here -->
                                    </tbody>
                                </table>
                                <div class="form-group mt-2">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col"></div>
                                        <div class="col">
                                            <p>Production Total Amount</p>
                                        </div>
                                        <div class="col">
                                            <input type="input" class="form-control" id="production_total_amount"
                                                name="production_total_amount" value="0"
                                                placeholder="Final Total Amount" readonly />
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group mt-2">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col"></div>
                                        <div class="col">
                                            <p>Consumption Item Cost</p>
                                        </div>
                                        <div class="col">
                                            <input type="input" class="form-control"
                                                id="consumption_total_item_amount" name="consumption_total_item_amount"
                                                value="0" placeholder="Final Total Amount" readonly />
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col"></div>
                                        <div class="col">
                                            Overhead Cost
                                        </div>
                                        <div class="col">
                                            <input type="input" class="form-control" id="overhead_total_amount"
                                                name="overhead_total_amount" value="0"
                                                placeholder="Final Total Amount" readonly />
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col"></div>
                                        <div class="col">
                                            Color Cost
                                        </div>
                                        <div class="col">
                                            <input type="input" class="form-control" id="color_total_amount"
                                                name="color_total_amount" value="0"
                                                placeholder="Final Total Amount" readonly />
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                </div>
                                {{--  <div class="form-group mt-2">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col"></div>
                                        <div class="col">
                                            Total Consumption Cost
                                        </div>
                                        <div class="col">
                                            <input type="input" class="form-control" id="consuption_total_amount"
                                                name="consuption_total_amount" value="0"
                                                placeholder="Final Total Amount" readonly />
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                </div>  --}}
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary saveMaterial">Save</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    //production add more and calculation
    $(document).ready(function() {
        var productiongrandTotalAmount = 0;
        $("#addProduction").click(function() {
            var productionitemid = $("#production_item_id").val();
            var productionitemName = $("#production_item_id :selected").text();
            var productionQty = $("#production_qty").val();
            var productionRate = $("#production_amount").val();

            var productiontotalAmount = productionQty * productionRate;
            productiongrandTotalAmount += productiontotalAmount;

            if (productionQty !== "") {
                var newRow = `<tr>
                            <td>1</td>
                            <td>${productionitemName}<input type="hidden" name="production_item_id[]" value="${productionitemid}" required /></td>
                            <td>${productionRate}<input type="hidden" name="production_rate[]" value="${productionRate}" required/></td>
                            <td>${productionQty}<input type="hidden" name="production_qty[]" value="${productionQty}" required/></td>
                            <td>${productiontotalAmount}<input type="hidden" name="production_totalamount[]" value="${productiontotalAmount}" required/></td>
                            <td><button type="button" class="btn btn-danger production-remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                        </tr>`;

                $("#production").append(newRow);
                $("#production_total_amount").val(productiongrandTotalAmount);
                $("#production_item_id, #production_qty, #production_amount").val("");
            } else {
                alert("Please select a value first");
            }
        });

        $(document).on("click", ".production-remove-row", function() {
            var removeproductionamount = parseFloat($(this).closest("tr").find("td:eq(4)").text());
            productiongrandTotalAmount -= removeproductionamount;

            $("#production_total_amount").val(Math.abs(productiongrandTotalAmount));
            $(this).closest("tr").remove();
        });
    });




    // Consumption Add more and calculation

    $(document).ready(function() {
        var consumptiongrandTotalAmount = 0;

        $("#addConsumption").click(function() {
            var consumptionitemid = $("#consumption_item_id").val();
            var consumptionitemName = $("#consumption_item_id :selected").text();
            var consumptionQty = $("#consumption_qty").val();
            var consumptionRate = $("#consumption_amount").val();

            if (consumptionQty !== "") {
                var consumptiontotalAmount = consumptionQty * consumptionRate;
                consumptiongrandTotalAmount += consumptiontotalAmount;

                var newRow = `<tr>
                <td>1</td>
                <td>${consumptionitemName}<input type="hidden" name="consumption_item_id[]" value="${consumptionitemid}" required /></td>
                <td>${consumptionRate}<input type="hidden" name="consumption_rate[]" value="${consumptionRate}" required/></td>
                <td>${consumptionQty}<input type="hidden" name="consumption_qty[]" value="${consumptionQty}" required/></td>
                <td>${consumptiontotalAmount}<input type="hidden" class="remove_consumption_amount" name="consumption_totalamount[]" value="${consumptiontotalAmount}" required/></td>
                <td><button type="button" class="btn btn-danger consumption-remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
            </tr>`;

                $("#consumption").append(newRow);
                $("#consumption_total_item_amount").val(consumptiongrandTotalAmount);

                $("#consumption_item_id, #consumption_qty, #consumption_amount").val("");
            } else {
                alert("Please select a value first");
            }
        });

        $(document).on("click", ".consumption-remove-row", function() {
            var removeconsumptionamount = parseFloat($(this).closest("tr").find(
                ".remove_consumption_amount").val());
            consumptiongrandTotalAmount -= removeconsumptionamount;

            $("#consumption_total_item_amount").val(Math.abs(consumptiongrandTotalAmount));

            $(this).closest("tr").remove();
        });
    });



    // overhead caluclation
    $(document).ready(function() {
        let overheadGrandTotalAmount = 0;

        $("#addOverHead").click(function() {
            const overheadItemId = $("#overhead_id").val();
            const overheadItemName = $("#overhead_id :selected").text();
            const overheadRate = +$("#overhead_amount").val();
            const consumptionTotalItemAmount = +$("#consumption_total_item_amount").val();

            if (!overheadRate) {
                alert("Please select a value first");
                return;
            }

            overheadGrandTotalAmount += overheadRate;

            const newRow = `<tr>
            <td>1</td>
            <td>${overheadItemName}<input type="hidden" name="overhead_item_id[]" value="${overheadItemId}" required /></td>
            <td>${overheadRate}<input type="hidden" name="overhead_rate[]" value="${overheadRate}" required/></td>
            <td><button type="button" class="btn btn-danger overhead-remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
        </tr>`;

            $("#overhead").append(newRow);
            $("#overhead_total_amount").val(overheadGrandTotalAmount);

            const consumptionTotalAmount = consumptionTotalItemAmount + overheadGrandTotalAmount;
            $("#consuption_total_amount").val(consumptionTotalAmount);

            $("#overhead_id, #overhead_amount").val("");
        });

        $(document).on("click", ".overhead-remove-row", function() {
            const removeOverheadAmount = +$(this).closest("tr").find("[name='overhead_rate[]']").val();
            overheadGrandTotalAmount -= removeOverheadAmount;

            $("#overhead_total_amount").val(Math.abs(overheadGrandTotalAmount));

            const consumptionGrandTotalAmount = +$("#consuption_total_amount").val();
            $("#consuption_total_amount").val(Math.abs(consumptionGrandTotalAmount -
                removeOverheadAmount));

            $(this).closest("tr").remove();
        });
    });


    // Color caluclation
    $(document).ready(function() {
        let colorGrandTotalAmount = 0;

        $("#addColor").click(function() {
            const colorItemId = $("#color_id").val();
            const colorItemName = $("#color_id :selected").text();
            const colorRate = +$("#color_amount").val();
            const consumptionTotalItemAmount = +$("#consumption_total_item_amount").val();

            if (!colorRate) {
                alert("Please select a value first");
                return;
            }

            colorGrandTotalAmount += colorRate;

            const newRow = `<tr>
            <td>1</td>
            <td>${colorItemName}<input type="hidden" name="color_item_id[]" value="${colorItemId}" required /></td>
            <td>${colorRate}<input type="hidden" name="color_rate[]" value="${colorRate}" required/></td>
            <td><button type="button" class="btn btn-danger color-remove-row"><i class="fa fa-times" aria-hidden="true"></i></button></td>
        </tr>`;

            $("#color").append(newRow);
            $("#color_total_amount").val(colorGrandTotalAmount);

            const consumptionTotalAmount = consumptionTotalItemAmount + colorGrandTotalAmount;
            $("#consuption_total_amount").val(consumptionTotalAmount);

            $("#color_id, #color_amount").val("");
        });

        $(document).on("click", ".color-remove-row", function() {
            const removeColorAmount = +$(this).closest("tr").find("[name='color_rate[]']").val();
            colorGrandTotalAmount -= removeColorAmount;

            $("#color_total_amount").val(Math.abs(colorGrandTotalAmount));

            const consumptionGrandTotalAmount = +$("#consuption_total_amount").val();
            $("#consuption_total_amount").val(Math.abs(consumptionGrandTotalAmount -
            removeColorAmount));

            $(this).closest("tr").remove();
        });
    });
</script>

@endsection
