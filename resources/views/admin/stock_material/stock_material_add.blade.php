@extends('admin.layout.main_app')
@section('title', 'Stock Material Add')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Stock Material Add</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Stock Material Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-22">
                        <div class="card">
                            <form role="form" action="{{ route('admin.stock.material.store') }}" method="post"
                                id="customer_add" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="stock_material_management_date">Date</label>
                                                <input type="date" class="form-control"
                                                    id="stock_material_management_date"
                                                    name="stock_material_management_date"
                                                    value="{{ old('stock_material_management_date') }}"
                                                    placeholder="Enter Date" required />
                                                @error('stock_material_management_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="execute_date">Execute Date</label>
                                                <input type="date" class="form-control" id="execute_date"
                                                    name="execute_date" value="" placeholder="Enter Date" required />
                                                @error('execute_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="source_location">Source Location</label>
                                            <select class="form-control select2bs4" id="source_location"
                                                name="source_location" style="width: 100%;" required>
                                                @foreach ($branch_list as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="destination_location">Destination Location</label>
                                            <select class="form-control select2bs4" id="destination_location"
                                                name="destination_location" style="width: 100%;" required>
                                                @foreach ($branch_list as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" id="addmore">
                                        <div class="form-group col-md-2">
                                            <label for="machine_name">Machine</label>
                                            <select class="form-control select2bs4" id="machine_name" style="width: 100%;"
                                                required>
                                                @foreach ($machine_list as $machine)
                                                    <option value="{{ $machine->name }}">{{ $machine->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="marka">Marka</label>
                                            <input type="text" class="form-control" placeholder="Marka" id="marka"
                                                required />
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="consumption_item_id">Item</label>
                                            <select class="form-control select2bs4" id="consumption_item_id"
                                                style="width: 100%;">
                                                @foreach ($item_list as $item)
                                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="consumption_qty">Qty(In Meter)</label>
                                            <input type="number" min="0" value="1" class="form-control"
                                                placeholder="Quantity" id="consumption_qty" />
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="consumption_amount">Amount</label>
                                            <input type="text" min="0" value="1" class="form-control"
                                                placeholder="Rate" id="consumption_amount" />
                                            <input type="hidden" min="0" value="1" class="form-control"
                                                placeholder="Rate" id="consumption_total_amount" />
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="color_id">Color</label>
                                            <select class="form-control select2bs4" id="color_id" style="width: 100%;">
                                                @foreach ($color_list as $color)
                                                    <option value="{{ $color->id }} {{ $color->usage_per_gram }}">
                                                        {{ $color->color_name }} ({{ $color->color_code }})</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" min="0" class="form-control" placeholder="GM"
                                                id="color_amount" />
                                            <input type="hidden" min="0" class="form-control" placeholder="GM"
                                                id="color_rate" />
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="chemical_id">Chemical</label>
                                            <select class="form-control select2bs4" id="chemical_id"
                                                style="width: 100%;">
                                                @foreach ($chemical_list as $chemical)
                                                    <option value="{{ $chemical->id }} {{ $chemical->value }}">
                                                        {{ $chemical->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" min="0" class="form-control" placeholder="GM"
                                                id="chemical_amount" />
                                            <input type="hidden" min="0" class="form-control" placeholder="GM"
                                                id="chemical_rate" />
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="overhead_amount">Overhead</label>
                                            <input type="hidden" min="0" class="form-control"
                                                placeholder="Amount" value="1" id="overhead_id" />
                                            <input type="text" min="0" class="form-control"
                                                placeholder="Amount" value="0" id="overhead_amount" />
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="production_item_id">Item</label>
                                            <select class="form-control select2bs4" id="production_item_id"
                                                style="width: 100%;">
                                                @foreach ($item_list as $item)
                                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="production_qty">Prod Qty (In meter)</label>
                                            <input type="number" min="0" class="form-control"
                                                placeholder="Quantity" id="production_qty" value="1" />
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="production_amount">Prod Rate</label>
                                            <input type="text" class="form-control" placeholder="Rate"
                                                id="production_amount" />
                                            <input type="hidden" min="0" value="1" class="form-control"
                                                placeholder="Rate" id="production_total_amount" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="button" class="btn btn-success" id="add">Add</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="data_table">
                                                <thead>
                                                    <tr>
                                                        <th>Machine</th>
                                                        <th>Marka</th>
                                                        <th>Item</th>
                                                        <th>Qty(In Meter)</th>
                                                        <th>Amount</th>
                                                        <th>Color</th>
                                                        <th>Chemical</th>
                                                        <th>Overhead</th>
                                                        <th>Item</th>
                                                        <th>Prod Qty(In Meter)</th>
                                                        <th>Prod Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Rows will be appended here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // jQuery Script
        $(document).ready(function() {
            $('#consumption_qty').on('keyup', function() {
                var inputValue = $(this).val(); // Get the value from input1
                $('#production_qty').val(inputValue);   // Set the value into input2
            });
        });

        $(document).ready(function() {
            // Cache jQuery selectors for better performance
            const $consumptionAmount = $('#consumption_amount');
            const $consumptionQty = $('#consumption_qty');
            const $consumptionTotalAmount = $('#consumption_total_amount');
            const $colorId = $('#color_id');
            const $colorAmount = $('#color_amount');
            const $colorTotalAmount = $('#color_total_amount');
            const $colorRate = $('#color_rate');
            const $chemicalId = $('#chemical_id');
            const $chemicalAmount = $('#chemical_amount');
            const $chemicalTotalAmount = $('#chemical_total_amount');
            const $chemicalRateAmount = $('#chemical_rate');
            const $overheadAmount = $('#overhead_amount');
            const $overheadTotalAmount = $('#overhead_total_amount');
            const $productionQty = $('#production_qty');
            const $productionAmount = $('#production_amount');
            const $productionTotalItemAmount = $('#production_total_amount');

            // Function to update consumption amounts based on input values
            function updateConsumptionAmounts() {
                let amount = parseFloat($consumptionAmount.val()) || 0;
                let qty = parseFloat($consumptionQty.val()) || 0;
                let totalAmount = amount * qty;
                $consumptionTotalAmount.val(totalAmount.toFixed(2));
            }

            // Function to update production amounts based on input values
            function updateProductionAmounts() {
                let amount = parseFloat($productionAmount.val()) || 0;
                let qty = parseFloat($productionQty.val()) || 0;
                let totalAmount = amount * qty;
                $productionTotalItemAmount.val(totalAmount.toFixed(2));
            }

            // Function to update amount and total based on selected item and quantity
            function updateAmountAndTotal($selector, $amountField, $totalField, $rateField) {
                let selectedValue = $selector.val();
                if (selectedValue) {
                    let parts = selectedValue.split(' ');
                    if (parts.length > 1) {
                        let usagePerGram = parseFloat(parts[1]);
                        let qty = parseFloat($consumptionQty.val()) || 0;
                        let amount = usagePerGram * qty * 10;
                        let rate = usagePerGram * amount;
                        $amountField.val(amount.toFixed(2));
                        $totalField.val(amount.toFixed(2));
                        $rateField.val(rate.toFixed(2));
                    }
                } else {
                    $amountField.val('');
                    $totalField.val('');
                    $rateField.val('');
                }
            }

            // Function to update the total amount for overhead
            function updateOverheadTotalAmount() {
                let overheadAmount = parseFloat($overheadAmount.val()) || 0;
                $overheadTotalAmount.val(overheadAmount.toFixed(2));
            }

            // Debounce function to limit the rate at which a function is called
            function debounce(func, delay) {
                let timeout;
                return function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(func, delay);
                };
            }

            // Debounced versions of the update functions
            const debouncedUpdateConsumptionAmounts = debounce(updateConsumptionAmounts, 300);
            const debouncedUpdateProductionAmounts = debounce(updateProductionAmounts, 300);

            // Attach event listeners to relevant elements
            $consumptionAmount.add($consumptionQty).on('keyup', debouncedUpdateConsumptionAmounts);
            $chemicalId.on('change', () => updateAmountAndTotal($chemicalId, $chemicalAmount, $chemicalTotalAmount,
                $chemicalRateAmount));
            $colorId.on('change', () => updateAmountAndTotal($colorId, $colorAmount, $colorTotalAmount,
            $colorRate));
            $overheadAmount.on('keyup change', updateOverheadTotalAmount);
            $productionAmount.add($productionQty).on('keyup', debouncedUpdateProductionAmounts);

            // Event listener for adding a new row to the table
            $('#add').click(function() {
                // Fetch input values
                const machineName = $('#machine_name').val();
                const marka = $('#marka').val();
                const consumptionItemId = $('#consumption_item_id').val();
                const consumptionItemName = $('#consumption_item_id option:selected').text();
                const consumptionQty = $('#consumption_qty').val();
                const consumptionAmount = $('#consumption_amount').val();
                const consumptionTotalAmount = $('#consumption_total_amount').val();
                const color = $('#color_id').val();
                const colorName = $('#color_id option:selected').text();
                const colorParts = color.split(' ');
                const colorId = parseFloat(colorParts[0]);
                const colorMeterValue = parseFloat(colorParts[1]);
                const colorAmount = $('#color_amount').val();
                const colorRate = $('#color_rate').val();
                const chemical = $('#chemical_id').val();
                const chemicalName = $('#chemical_id option:selected').text();
                const chemicalParts = chemical.split(' ');
                const chemicalId = parseFloat(chemicalParts[0]);
                const chemicalMeterValue = parseFloat(chemicalParts[1]);
                const chemicalAmount = $('#chemical_amount').val();
                const chemicalRate = $('#chemical_rate').val();
                const overheadId = $('#overhead_id').val();
                const overheadAmount = $('#overhead_amount').val();
                const productionItemId = $('#production_item_id').val();
                const productionItemName = $('#production_item_id option:selected').text();
                const productionQty = $('#production_qty').val();
                const productionAmount = $('#production_amount').val();
                const productionTotalAmount = $('#production_total_amount').val();

                // Create a new row with the fetched values
                const newRow = `
                <tr>
                    <td>
                        ${machineName}
                        <input type="hidden" name="machine_name[]" value="${machineName}" required />
                    </td>
                    <td>
                        ${marka}
                        <input type="hidden" name="marka[]" value="${marka}" required />
                    </td>
                    <td>
                        ${consumptionItemName}
                        <input type="hidden" name="consumption_item_id[]" value="${consumptionItemId}" required />
                    </td>
                    <td>
                        ${consumptionQty}
                        <input type="hidden" name="consumption_qty[]" value="${consumptionQty}" required/>
                    </td>
                    <td>
                        ${consumptionAmount}
                        <input type="hidden" name="consumption_amount[]" value="${consumptionAmount}" required/>
                        <input type="hidden" name="consumption_totalamount[]" value="${consumptionTotalAmount}" required/>
                        <input type="hidden" name="consuption_total_amount[]" value="${consumptionTotalAmount}" required/>
                    </td>
                    <td>
                        ${colorName}
                        <input type="hidden" name="color_item_id[]" value="${colorId}" required />
                        <input type="hidden" name="color_gram[]" value="${colorMeterValue}" required />
                        <input type="hidden" name="color_amount[]" value="${colorAmount}" required/>
                        <input type="hidden" name="color_rate[]" value="${colorRate}" required/>
                        <input type="hidden" name="color_total_amount[]" value="${colorRate}" required/>
                    </td>
                    <td>
                        ${chemicalName}
                        <input type="hidden" name="chemical_item_id[]" value="${chemicalId}" required />
                        <input type="hidden" name="chemical_gram[]" value="${chemicalMeterValue}" required />
                        <input type="hidden" name="chemical_amount[]" value="${chemicalAmount}" required/>
                        <input type="hidden" name="chemical_rate[]" value="${chemicalRate}" required/>
                        <input type="hidden" name="chemical_total_amount[]" value="${chemicalRate}" required/>
                    </td>
                    <td>
                        ${overheadAmount}
                        <input type="hidden" name="overhead_item_id[]" value="${overheadId}" required />
                        <input type="hidden" name="overhead_amount[]" value="${overheadAmount}" required />
                        <input type="hidden" name="overhead_total_amount[]" value="${overheadAmount}" required />
                    </td>
                    <td>
                        ${productionItemName}
                        <input type="hidden" name="production_item_id[]" value="${productionItemId}" required />
                    </td>
                    <td>
                        ${productionQty}
                        <input type="hidden" name="production_qty[]" value="${productionQty}" required />
                    </td>
                    <td>
                        ${productionAmount}
                        <input type="hidden" name="production_amount[]" value="${productionAmount}" required/>
                        <input type="hidden" name="production_totalamount[]" value="${productionTotalAmount}" required/>
                        <input type="hidden" name="production_total_amount[]" value="${productionTotalAmount}" required/>
                    </td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>`;

                // Append the new row to the table
                $('#data_table tbody').append(newRow);
            });

            // Event listener for removing a row from the table
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>

@endsection
