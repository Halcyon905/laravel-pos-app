<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use App\Models\Payment;

class PaymentController extends Controller
{
    public static function create_blank_payment(int $id)
    {
        $new_payment = new Payment;
        $new_payment->sale_id = $id;
        $new_payment->total = 0;
        $new_payment->member_id = 1;
        $new_payment->save();

        return;
    }

    public function update(Request $request)
    {
        $member = MemberController::find_one_member_by_phone($request->phone);
        if($member == null) {
            $request->flash();
            return Redirect::route('payment')->with('status', 'Phone number not found.');
        }
        $payment = Payment::where('sale_id', '=', $request->sale_id)->first();
        $payment->member_id = $member->id;
        $payment->total = $payment->total * 0.9;
        $payment->save();

        return Redirect::route('payment')->with('status', 'Member added.');
    }

    public function destroy(Request $request)
    {
        return "confirm";
    }
}
