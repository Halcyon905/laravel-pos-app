<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Validation\Validator;
use Illuminate\View\View;

use App\Models\Sale;
use App\Models\Payment;

class SaleController extends Controller
{
    public static function get_latest_sale_by_employee(Request $request) {
        return Sale::where('employee_id', '=', $request->user()->id)->orderBy('id', 'DESC')->first();
    }

    public static function update_sale_payment_status(string $status, int $sale_id) {
        $sale = Sale::where('id', '=', $sale_id)->first();
        $payment = $sale->payment;

        $payment->total = array_sum($sale->sales_line_item()->pluck('total')->all());
        $payment->payment_type = $status;
        $payment->save();
    }

    public function create(Request $request)
    {
        $sale = new Sale;
        $sale->employee_id = $request->user()->id;
        $sale->save();

        $new_payment = new Payment;
        $new_payment->sale_id = $sale->id;
        $new_payment->total = 0;
        $new_payment->save();

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
        $sale->payment->payment_type = $request->payment;

        $sale->payment->save();
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
