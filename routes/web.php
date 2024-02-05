<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesLineItemController;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/dashboard', function (Request $request) {
    $sale = SaleController::get_latest_sale_by_employee($request);

    if($sale == null) {
        return Redirect::route('sale.create');
    }
    elseif($sale->payment_confirm == 1) {
        return Redirect::route('payment')->with('sale_id', $sale->id);
    }
    
    return view('dashboard')->with('sale', $sale)
                            ->with('sale_items', $sale->sales_line_item()->get())
                            ->with('stock', ItemController::get_available_items());
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/confirm_pay', function (Request $request) {
    $sale = SaleController::get_latest_sale_by_employee($request);
    if($sale->payment_confirm == 0){
        SaleController::update_sale_payment_status(1, $sale->id);
    }
    return view('payment')->with('grand_total', $sale->total)->with('sale_id', $sale->id);
})->middleware(['auth', 'verified'])->name('payment');

Route::get('/stock', function (Request $request) {

    $stock = ItemController::get_all_items();
    
    return view('stock')->with('stock', $stock);
})->middleware(['auth', 'verified'])->name('stock');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/item', [ItemController::class, 'create'])->name('item.create');
    Route::patch('/item', [ItemController::class, 'update'])->name('item.update');
    Route::delete('/item', [ItemController::class, 'destroy'])->name('item.destroy');

    Route::get('/sale', [SaleController::class, 'create'])->name('sale.create');
    Route::patch('/sale', [SaleController::class, 'update'])->name('sale.update');

    Route::post('/add_item', [SalesLineItemController::class, 'create'])->name('salesLineItem.create');
    Route::delete('/delete_item', [SalesLineItemController::class, 'destroy'])->name('salesLineItem.delete');
});

require __DIR__.'/auth.php';
