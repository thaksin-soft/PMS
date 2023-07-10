<?php

namespace App\Http\Controllers;

use App\Models\PurchasingInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashbourdController extends Controller
{
    public function index(Request $request){

        if (Auth::user()->hasRole('superadministrator')) {
            return view('admin-dashboard');
        } else if (Auth::user()->hasRole('purchaser')){

            if ($request->session()->has('choose-base') && $request->session()->get('choose-base') == 'pp') {
                $ic_unit = DB::connection('pgsql_pp')->select('SELECT * FROM ic_unit');
                $ic_group = DB::connection('pgsql_pp')->select('SELECT * FROM ic_group');
                $ic_category = DB::connection('pgsql_pp')->select('SELECT * FROM ic_category');
                $ic_warehouse = DB::connection('pgsql_pp')->select('SELECT * FROM ic_warehouse');
            } else {
                $ic_unit = DB::connection('pgsql_od')->select('SELECT * FROM ic_unit');
                $ic_group = DB::connection('pgsql_od')->select('SELECT * FROM ic_group');
                $ic_category = DB::connection('pgsql_od')->select('SELECT * FROM ic_category');
                $ic_warehouse = DB::connection('pgsql_od')->select('SELECT * FROM ic_warehouse');
            }
            return view('purchasing-dashboard', compact('ic_unit', 'ic_group', 'ic_category', 'ic_warehouse'));
        } else if (Auth::user()->hasRole('accountant')){
            return view('accountant-dashboard');
        } else if (Auth::user()->hasRole('purchasinghead')){
            if ($request->session()->has('choose-base') && $request->session()->get('choose-base') == 'pp') {
                $ic_unit = DB::connection('pgsql_pp')->select('SELECT * FROM ic_unit');
                $ic_group = DB::connection('pgsql_pp')->select('SELECT * FROM ic_group');
                $ic_category = DB::connection('pgsql_pp')->select('SELECT * FROM ic_category');
                $ic_warehouse = DB::connection('pgsql_pp')->select('SELECT * FROM ic_warehouse');
            } else {
                $ic_unit = DB::connection('pgsql_od')->select('SELECT * FROM ic_unit');
                $ic_group = DB::connection('pgsql_od')->select('SELECT * FROM ic_group');
                $ic_category = DB::connection('pgsql_od')->select('SELECT * FROM ic_category');
                $ic_warehouse = DB::connection('pgsql_od')->select('SELECT * FROM ic_warehouse');
            }

            return view('admin-dashboard');
            
            //return view('purchasinghead-dashboard', compact('ic_unit', 'ic_group', 'ic_category', 'ic_warehouse'));
        } else if (Auth::user()->hasRole('accountanter')){
            return view('accountanter-dashboard');

        } else if (Auth::user()->hasRole('secretarypurchase')){
            if ($request->session()->has('choose-base') && $request->session()->get('choose-base') == 'pp') {
                $ic_unit = DB::connection('pgsql_pp')->select('SELECT * FROM ic_unit');
                $ic_group = DB::connection('pgsql_pp')->select('SELECT * FROM ic_group');
                $ic_category = DB::connection('pgsql_pp')->select('SELECT * FROM ic_category');
                $ic_warehouse = DB::connection('pgsql_pp')->select('SELECT * FROM ic_warehouse');
            } else {
                $ic_unit = DB::connection('pgsql_od')->select('SELECT * FROM ic_unit');
                $ic_group = DB::connection('pgsql_od')->select('SELECT * FROM ic_group');
                $ic_category = DB::connection('pgsql_od')->select('SELECT * FROM ic_category');
                $ic_warehouse = DB::connection('pgsql_od')->select('SELECT * FROM ic_warehouse');
            }

            return view('purchasing-dashboard', compact('ic_unit', 'ic_group', 'ic_category', 'ic_warehouse'));
        }else {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }

    public function create_index(Request $request)
    {
        if ($request->session()->has('choose-base') && $request->session()->get('choose-base') == 'pp') {
            $ic_unit = DB::connection('pgsql_pp')->select('SELECT * FROM ic_unit');
            $ic_group = DB::connection('pgsql_pp')->select('SELECT * FROM ic_group');
            $ic_category = DB::connection('pgsql_pp')->select('SELECT * FROM ic_category');
            $ic_warehouse = DB::connection('pgsql_pp')->select('SELECT * FROM ic_warehouse');
        } else {
            $ic_unit = DB::connection('pgsql_od')->select('SELECT * FROM ic_unit');
            $ic_group = DB::connection('pgsql_od')->select('SELECT * FROM ic_group');
            $ic_category = DB::connection('pgsql_od')->select('SELECT * FROM ic_category');
            $ic_warehouse = DB::connection('pgsql_od')->select('SELECT * FROM ic_warehouse');
        }
        return view('purchasing-dashboard', compact('ic_unit', 'ic_group', 'ic_category', 'ic_warehouse'));
    }

}
