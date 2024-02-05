<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\View\View;

use App\Models\Item;

class ItemController extends Controller
{
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);

        $item = new Item;
        $item->name = $request->item_name;
        $item->stock = $request->stock;
        $item->price = $request->price;

        $item->save();

        return Redirect::route('stock')->with('status', 'Item created.');
    }

    public function update(Request $request)
    {
        $item = Item::where('id', '=', $request->item_id)->first();
        $item->name = $request->name;
        $item->stock = $request->stock;
        $item->price = $request->price;
        $item->save();

        $affected = $item->sales_line_item()->get();
        foreach($affected as $to_update_item) {
            if($to_update_item->sale->payment_confirm != 0) {
                continue;
            }
            $to_update_item->sale->decrement('total', $to_update_item->total);

            $to_update_item->total = $to_update_item->quantity * $item->price;
            $to_update_item->save();

            $to_update_item->sale->increment('total', $to_update_item->total);
        }

        return Redirect::route('stock')->with('status', 'Item Info updated.');
    }

    public function destroy(Request $request)
    {
        Item::where('id', '=', $request->item_id)->delete();
        return Redirect::route('stock')->with('status', 'Item deleted.');
    }

    public static function get_all_items() {
        return Item::get();
    }

    public static function get_available_items() {
        return Item::where('stock', '>', 0)->get();
    }
}
