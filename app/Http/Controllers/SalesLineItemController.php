<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Validation\Rule;

use App\Models\SalesLineItem;
use App\Models\Item;

class SalesLineItemController extends Controller
{
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'item_id' => [Rule::In(Item::where('id', '=', $request->item_id)->pluck('id')->all())],
            'quantity' => 'required|numeric|max:'.Item::where('id', '=', $request->item_id)->pluck('stock')->first()
        ], [
            'item_id.in' => 'Please select a viable item option.',
            'quantity.max' => 'Quantity exceeds the available stock: '.Item::where('id', '=', $request->item_id)->pluck('stock')->first()
        ]);

        $sales_line_item = SalesLineItem::where('sale_id', '=', $request->sale_id)->where('item_id', '=', $request->item_id)->first();
        if($sales_line_item != null) {
            $sales_line_item->increment('quantity', $request->quantity);
            $sales_line_item->increment('total', ($request->quantity * $sales_line_item->item->price));
        }
        else {
            $new_salesLineItem = new SalesLineItem;

            $new_salesLineItem->sale_id = $request->sale_id;
            $new_salesLineItem->item_id = $request->item_id;
            $new_salesLineItem->quantity = $request->quantity;

            $new_salesLineItem->save();
            
            $new_salesLineItem->increment('total', ($new_salesLineItem->quantity * $new_salesLineItem->item->price));
        }

        return Redirect::route('dashboard')->with('status', 'Item added.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $sales_line_item = SalesLineItem::where('id', '=', $request->id)->first();
        $sales_line_item->delete();
        return Redirect::route('dashboard')->with('status', 'Item removed.');
    }
}
