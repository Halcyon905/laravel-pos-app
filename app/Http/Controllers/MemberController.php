<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Member;

class MemberController extends Controller
{
    public static function find_one_member_by_phone(string $phone) {
        return Member::where('phone', '=', $phone)->first();
    }
    public function create(Request $request)
    {
        return "confirm";
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
