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
    public static function get_latest_sale_by_employee(Request $request) {
        return Sale::where('employee_id', '=', $request->user()->id)->orderBy('id', 'DESC')->first();
    }

    public static function update_sale_payment_status(int $status, int $sale_id) {
        Sale::where('id', '=', $sale_id)->update([
            'payment_confirm' => $status,
        ]);
    }

    public function create(Request $request)
    {
        $sale = new Sale;

        $sale->employee_id = $request->user()->id;
        $sale->customer = "temp";
        $sale->payment_method = "cash";

        $sale->save();

        return Redirect::route('dashboard')->with('status', 'Sale created.');
    }

    public function confirm(Request $request)
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
