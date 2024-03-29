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
    public static function get_all_items() {
        return Item::get();
    }

    public static function get_available_items() {
        return Item::where('stock', '>', 0)->get();
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'new_item_name' => 'required',
            'new_stock' => 'required|numeric',
            'new_price' => 'required|numeric',
        ], [
            'new_item_name.required' => 'New item name can not be blank.',
            'new_stock.required' => 'New item stock can not be blank.',
            'new_price.required' => 'New item price can not be blank.',
            'new_stock.numeric' => 'New item stock must be a number.',
            'new_price.numeric' => 'New item price must be a number.',
        ]);

        $item = new Item;
        $item->name = $request->new_item_name;
        $item->stock = $request->new_stock;
        $item->price = $request->new_price;

        $item->save();

        return Redirect::route('stock')->with('status', 'Item created.');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $item = Item::where('id', '=', $request->item_id)->first();
        $item->name = $request->name;
        $item->stock = $request->stock;
        $item->price = $request->price;
        $item->save();

        $affected = $item->sales_line_item()->get();
        foreach($affected as $to_update_item) {
            if($to_update_item->sale->payment->payment_type != 'unfinished') {
                continue;
            }
            $to_update_item->total = $to_update_item->quantity * $item->price;
            $to_update_item->save();
        }

        return Redirect::route('stock')->with('status', 'Item Info updated.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Item::where('id', '=', $request->item_id)->delete();
        return Redirect::route('stock')->with('status', 'Item deleted.');
    }
}
