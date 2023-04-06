<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function set_choose_base(Request $request)
    {
        $request->session()->forget('ic-unit');
        $request->session()->forget('ic-group');
        $request->session()->forget('ic-category');
        $request->session()->forget('ic-warehouse');
        $base = $request->base;
        $request->session()->put('choose-base', $base);
        return response()->json('success');
    }
}