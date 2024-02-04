<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Validation\Validator;
use Illuminate\View\View;

use App\Models\Sale;

class SaleController extends Controller
{
    public function create(Request $request)
    {
        $sale = new Sale;

        $sale->employee_id = $request->user()->id;
        $sale->customer = "temp";
        $sale->payment_method = "cash";

        $sale->save();

        return Redirect::route('dashboard')->with('status', 'Sale created.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'pay_confirm' => 'required',
        ], [
            'pay_confirm.required' => 'Please check the box for confirmation first.',
        ]);
        
        $sale = Sale::where('id', '=', $request->sale_id)->first();
        $sale->payment_method = $request->payment;
        $sale->payment_confirm = 2;

        $sale->save();

        $bought_items = $sale->sales_line_item()->get();

        foreach($bought_items as $item) {
            $item->item->decrement('stock', $item->quantity);
        }

        return Redirect::route('sale.create');
    }

    public function destroy(Request $request)
    {
        return "confirm";
    }
}
