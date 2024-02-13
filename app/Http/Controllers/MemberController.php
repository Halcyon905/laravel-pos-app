<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use App\Models\Member;

class MemberController extends Controller
{
    public static function find_one_member_by_phone(string $phone) {
        return Member::where('phone', '=', $phone)->first();
    }
    public function create(Request $request)
    {
        $request->validate([
            "new_member_name" => "required",
            "new_phone" => "required|unique:members,phone"
        ], [
            "new_phone.unique" => "This phone number is already in use."
        ]);
        $new_member = new Member;
        $new_member->full_name = $request->new_member_name;
        $new_member->phone = $request->new_phone;
        $new_member->save();

        return Redirect::route('member')->with('status', 'Member created.');
    }

    public function update(Request $request)
    {
        return "confirm";
    }

    public function destroy(Request $request)
    {
        return "confirm";
    }
}
