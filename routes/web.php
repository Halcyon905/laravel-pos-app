<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesLineItemController;

use App\Models\Sale;
use App\Models\Item;
use App\Models\SalesLineItem;

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

    $sale = Sale::where('employee_id', '=', $request->user()->id)->orderBy('id', 'DESC')->first();

    if($sale == null) {
        return Redirect::route('sale.create');
    }
    elseif($sale->payment_confirm == 1) {
        return Redirect::route('payment')->with('sale_id', $sale->id);
    }

    $available = ItemController::get_available_items();
    
    return view('dashboard')->with('sale', $sale)
                            ->with('sale_items', $sale->sales_line_item()->get())
                            ->with('stock', $available);
})->middleware(['auth', 'verified'])->name('dashboard');

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

    Route::get('/confirm_pay', function (Request $request) {
        $sale = Sale::where('employee_id', '=', $request->user()->id)->orderBy('id', 'DESC')->first();
        if($sale->payment_confirm == 0){
            $sale->payment_confirm = 1;
            $sale->save();
        }
        return view('payment')->with('grand_total', $sale->total)->with('sale_id', $sale->id);
    })->name('payment');

    Route::post('/add_item', [SalesLineItemController::class, 'create'])->name('salesLineItem.create');
    Route::delete('/delete_item', [SalesLineItemController::class, 'destroy'])->name('salesLineItem.delete');
});

require __DIR__.'/auth.php';
