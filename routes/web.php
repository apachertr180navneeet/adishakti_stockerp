<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    LoginController,
    DashboardController,
    VendorController,
    OverheadController,
    CompanyController,
    UnitController,
    UserController,
    ItemController,
    StockInController,
    StockController,
    StockDispatchController,
    CreditNoteController,
    DebitNoteController,
    StockMaterialManagemntController,
    StockChallanController,
    CustomerController,
    ConditionMasterController,
    StockReportController,
    ColorController,
    MachineController,
    BatchController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::name('download.')->prefix('download')->controller(DownloadReportController::class)->group(function () {
    Route::get('report/{id}', 'index')->name('report');
});
// Admin URL
Route::name('admin.')->prefix('admin')->controller(LoginController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('post-login','postLogin')->name('login.post');
    Route::get('forgotpassword','forgotpassword')->name('forget.password');
    Route::post('forgotpasswordpost','forgotpasswordpost')->name('forget.password.post');
});
Route::name('admin.')->prefix('admin')->controller(DashboardController::class)->middleware('web')->group(function () {
    Route::get('dashboard', 'dashboard')->name('dashboard');
    Route::get('setting', 'setting')->name('setting');
    Route::post('setting_edit', 'edit')->name('setting.edit');
    Route::get('logout', 'logout')->name('logout');
});
Route::name('admin.')->prefix('admin')->controller(VendorController::class)->middleware('web')->group(function () {
    Route::get('vendor_list', 'index')->name('vendor.list');
    Route::get('vendor_add', 'create')->name('vendor.add');
    Route::post('vendor_store', 'store')->name('vendor.store');
    Route::get('vendor_edit/{id}', 'edit')->name('vendor.edit');
    Route::post('vendor_update', 'update')->name('vendor.update');
    Route::delete('vendor_delete/{id}', 'delete')->name('vendor.delete');
    Route::get('vendor_status/{id}', 'status')->name('vendor.status');
});
Route::name('admin.')->prefix('admin')->controller(OverheadController::class)->middleware('web')->group(function () {
    Route::get('overhead_list', 'index')->name('overhead.list');
    Route::get('overhead_add', 'create')->name('overhead.add');
    Route::post('overhead_store', 'store')->name('overhead.store');
    Route::get('overhead_edit/{id}', 'edit')->name('overhead.edit');
    Route::post('overhead_update', 'update')->name('overhead.update');
    Route::delete('overhead_delete/{id}', 'delete')->name('overhead.delete');
    Route::get('overhead_status/{id}', 'status')->name('overhead.status');
});
Route::name('admin.')->prefix('admin')->controller(CompanyController::class)->middleware('web')->group(function () {
    Route::get('company_list', 'index')->name('company.list');
    Route::get('company_add', 'create')->name('company.add');
    Route::post('company_store', 'store')->name('company.store');
    Route::get('company_edit/{id}', 'edit')->name('company.edit');
    Route::post('company_update', 'update')->name('company.update');
    Route::delete('company_delete/{id}', 'delete')->name('company.delete');
    Route::get('company_status/{id}', 'status')->name('company.status');
});
Route::name('admin.')->prefix('admin')->controller(UnitController::class)->middleware('web')->group(function () {
    Route::get('unit_list', 'index')->name('unit.list');
    Route::get('unit_add', 'create')->name('unit.add');
    Route::post('unit_store', 'store')->name('unit.store');
    Route::get('unit_edit/{id}', 'edit')->name('unit.edit');
    Route::post('unit_update', 'update')->name('unit.update');
    Route::delete('unit_delete/{id}', 'delete')->name('unit.delete');
    Route::get('unit_status/{id}', 'status')->name('unit.status');
});
Route::name('admin.')->prefix('admin')->controller(ColorController::class)->middleware('web')->group(function () {
    Route::get('color_list', 'index')->name('color.list');
    Route::get('color_add', 'create')->name('color.add');
    Route::post('colort_store', 'store')->name('color.store');
    Route::get('color_edit/{id}', 'edit')->name('color.edit');
    Route::post('color_update', 'update')->name('color.update');
    Route::delete('color_delete/{id}', 'delete')->name('color.delete');
    Route::get('color_status/{id}', 'status')->name('color.status');
    Route::get('color_stock_in', 'colorstockin')->name('color.stock.in');
    Route::get('add_color_stock', 'addcolorstock')->name('add.color.stock');
    Route::post('color_stock_store', 'color_stock_store')->name('color.stock.store');
    Route::get('color_stock_edit/{id}', 'colorstockedit')->name('stock.color.edit');
});
Route::name('admin.')->prefix('admin')->controller(MachineController::class)->middleware('web')->group(function () {
    Route::get('machine_list', 'index')->name('machine.list');
    Route::get('machine_add', 'create')->name('machine.add');
    Route::post('machine_store', 'store')->name('machine.store');
    Route::get('machine_edit/{id}', 'edit')->name('machine.edit');
    Route::post('machine_update', 'update')->name('machine.update');
    Route::delete('machine_delete/{id}', 'delete')->name('machine.delete');
    Route::get('machine_status/{id}', 'status')->name('machine.status');
});

Route::name('admin.')->prefix('admin')->controller(BatchController::class)->middleware('web')->group(function () {
    Route::get('batch_list', 'index')->name('batch.list');
    Route::get('batch_add', 'create')->name('batch.add');
    Route::post('batch_store', 'store')->name('batch.store');
    Route::get('batch_edit/{id}', 'edit')->name('batch.edit');
    Route::post('batch_update', 'update')->name('batch.update');
    Route::delete('batch_delete/{id}', 'delete')->name('batch.delete');
    Route::get('batch_status/{id}', 'status')->name('batch.status');
});

Route::name('admin.')->prefix('admin')->controller(ConditionMasterController::class)->middleware('web')->group(function () {
    Route::get('chemical_list', 'index')->name('condition.list');
    Route::get('chemical_add', 'create')->name('condition.add');
    Route::post('chemical_store', 'store')->name('condition.store');
    Route::get('chemical_edit/{id}', 'edit')->name('condition.edit');
    Route::post('chemical_update', 'update')->name('condition.update');
    Route::delete('chemical_delete/{id}', 'delete')->name('condition.delete');
    Route::get('chemical_status/{id}', 'status')->name('condition.status');
    Route::get('chemical_stock_in', 'chemicalstockin')->name('chemical.stock.in');
    Route::get('add_chemical_stock', 'addchemicalstock')->name('add.chemical.stock');
    Route::post('chemical_stock_store', 'chemical_stock_store')->name('chemical.stock.store');
    Route::get('chemical_stock_edit/{id}', 'chemicalstockedit')->name('stock.chemical.edit');
});
Route::name('admin.')->prefix('admin')->controller(UserController::class)->middleware('web')->group(function () {
    Route::get('user_list', 'index')->name('user.list');
    Route::get('user_add', 'create')->name('user.add');
    Route::post('user_store', 'store')->name('user.store');
    Route::get('user_edit/{id}', 'edit')->name('user.edit');
    Route::post('user_update', 'update')->name('user.update');
    Route::delete('user_delete/{id}', 'delete')->name('user.delete');
    Route::get('user_status/{id}', 'status')->name('user.status');
});
Route::name('admin.')->prefix('admin')->controller(CustomerController::class)->middleware('web')->group(function () {
    Route::get('customer_list', 'index')->name('customer.list');
    Route::get('customer_add', 'create')->name('customer.add');
    Route::post('customer_store', 'store')->name('customer.store');
    Route::get('customer_edit/{id}', 'edit')->name('customer.edit');
    Route::post('customer_update', 'update')->name('customer.update');
    Route::delete('customer_delete/{id}', 'delete')->name('customer.delete');
    Route::get('customer_status/{id}', 'status')->name('customer.status');
});
Route::name('admin.')->prefix('admin')->controller(ItemController::class)->middleware('web')->group(function () {
    Route::get('item_list', 'index')->name('item.list');
    Route::get('item_add', 'create')->name('item.add');
    Route::post('item_store', 'store')->name('item.store');
    Route::get('item_edit/{id}', 'edit')->name('item.edit');
    Route::post('item_update', 'update')->name('item.update');
    Route::delete('item_delete/{id}', 'delete')->name('item.delete');
    Route::get('item_status/{id}', 'status')->name('item.status');
});
Route::name('admin.')->prefix('admin')->controller(StockController::class)->middleware('web')->group(function () {
    Route::get('stock_in_list', 'index')->name('stock.in.list');
    Route::get('stock_in_add', 'create')->name('stock.in.add');
    Route::post('stock_in_store', 'store')->name('stock.in.store');
    Route::get('stock_in_edit/{id}', 'edit')->name('stock.in.edit');
    Route::get('stock_in_serach', 'serach')->name('stock.in.serach');
    Route::post('stock_in_update', 'update')->name('stock.in.update');
    Route::delete('stock_in_delete/{id}', 'delete')->name('stock.in.delete');
    Route::get('stock_in_status/{id}', 'status')->name('stock.in.status');
});
Route::name('admin.')->prefix('admin')->controller(StockDispatchController::class)->middleware('web')->group(function () {
    Route::get('stock_dispatch_list', 'index')->name('stock.dispatch.list');
    Route::get('stock_dispatch_add', 'create')->name('stock.dispatch.add');
    Route::post('stock_dispatch_store', 'store')->name('stock.dispatch.store');
    Route::get('stock_dispatch_edit/{id}', 'edit')->name('stock.dispatch.edit');
    Route::post('stock_dispatch_update', 'update')->name('stock.dispatch.update');
    Route::delete('stock_dispatch_delete/{id}', 'delete')->name('stock.dispatch.delete');
    Route::get('stock_dispatch_status/{id}', 'status')->name('stock.dispatch.status');
    Route::get('stock_dispatch_serach', 'serach')->name('stock.dispatch.serach');
});
Route::name('admin.')->prefix('admin')->controller(CreditNoteController::class)->middleware('web')->group(function () {
    Route::get('credit_note_list', 'index')->name('credit.note.list');
    Route::get('credit_note_add', 'create')->name('credit.note.add');
    Route::post('credit_note_store', 'store')->name('credit.note.store');
    Route::get('credit_note_edit/{id}', 'edit')->name('credit.note.edit');
    Route::post('credit_note_update', 'update')->name('credit.note.update');
    Route::delete('credit_note_delete/{id}', 'delete')->name('credit.note.delete');
    Route::get('credit_note_status/{id}', 'status')->name('credit.note.status');
    Route::get('credit_note_serach', 'serach')->name('credit.note.serach');
});
Route::name('admin.')->prefix('admin')->controller(DebitNoteController::class)->middleware('web')->group(function () {
    Route::get('debit_note_list', 'index')->name('debit.note.list');
    Route::get('debit_note_add', 'create')->name('debit.note.add');
    Route::post('debit_note_store', 'store')->name('debit.note.store');
    Route::get('debit_note_edit/{id}', 'edit')->name('debit.note.edit');
    Route::post('debit_note_update', 'update')->name('debit.note.update');
    Route::delete('debit_note_delete/{id}', 'delete')->name('debit.note.delete');
    Route::get('debit_note_status/{id}', 'status')->name('debit.note.status');
    Route::get('debit_note_serach', 'serach')->name('debit.note.serach');
});
Route::name('admin.')->prefix('admin')->controller(StockMaterialManagemntController::class)->middleware('web')->group(function () {
    Route::get('stock_material_list', 'index')->name('stock.material.list');
    Route::get('stock_material_add', 'create')->name('stock.material.add');
    Route::post('stock_material_store', 'store')->name('stock.material.store');
    Route::get('stock_material_edit/{id}', 'edit')->name('stock.material.edit');
    Route::post('stock_material_update', 'update')->name('stock.material.update');
    Route::delete('stock_material_delete/{id}', 'delete')->name('stock.material.delete');
    Route::get('stock_material_status/{id}', 'status')->name('stock.material.status');
    Route::get('stock_material_serach', 'serach')->name('stock.material.serach');
});
Route::name('admin.')->prefix('admin')->controller(StockChallanController::class)->middleware('web')->group(function () {
    Route::get('stock_challan_list', 'index')->name('stock.challan.list');
    Route::get('stock_challan_add', 'create')->name('stock.challan.add');
    Route::post('stock_challan_store', 'store')->name('stock.challan.store');
    Route::get('stock_challan_edit/{id}', 'edit')->name('stock.challan.edit');
    Route::post('stock_challan_update', 'update')->name('stock.challan.update');
    Route::delete('stock_challan_delete/{id}', 'delete')->name('stock.challan.delete');
    Route::get('stock_challan_status/{id}', 'status')->name('stock.challan.status');
    Route::get('stock_challan_serach', 'serach')->name('stock.challan.serach');
    Route::get('order_dispatch_list', 'order_dispatch_list')->name('order.dispatch.list');
    Route::get('order_dispatch/{id}', 'order_dispatch')->name('order.dispatch');
    Route::post('order_dispatch_update', 'order_dispatch_update')->name('order.dispatch.update');
    Route::get('disptach_serach', 'disptach_serach')->name('dispatch.serach');
    Route::get('order_dispatch_view/{id}', 'order_dispatch_view')->name('order.dispatch.view');
});

// Report Url

Route::name('admin.')->prefix('admin')->controller(StockReportController::class)->middleware('web')->group(function () {
    Route::get('total_stock_report', 'total_stock_report')->name('total.stock.report');
    Route::get('total_stock_report_filter', 'total_stock_report_filter')->name('total.stock.report.filter');
    Route::get('color_report', 'color_report')->name('color.report');
    Route::get('color_report_filter', 'color_report_filter')->name('color.report.filter');
    Route::get('chemical_report', 'chemical_report')->name('chemical.report');
    Route::get('chemical_report_filter', 'chemical_report_filter')->name('chemical.report.filter');
    Route::get('machine_report', 'machine_report')->name('machine.report');
    Route::get('machine_report_filter', 'machine_report_filter')->name('machine.report.filter');
});