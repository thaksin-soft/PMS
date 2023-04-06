<?php

namespace App\Http\Controllers\ManageData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupWarehouseController extends Controller
{
    public function index(Request $request)
    {
        $ch = $request->session()->get('choose-base');
        //ic category
        if ($ch == 'pp') {
            $ic_group = DB::connection('pgsql_pp')->select('SELECT * FROM public.ic_group');
        } else {
            $ic_group = DB::connection('pgsql_od')->select('SELECT * FROM public.ic_group');
        }
        return view('manage-data.group-warehouse', compact('ic_group'));
    }

    public function insert_group_wh(Request $request)
    {
        try {
            $group_code = $request->group_code;
            $warehouse_code = $request->warehouse_code;
            $ch = $request->session()->get('choose-base');
            if ($ch == 'pp') {
                DB::connection('pgsql_pp')->insert('INSERT INTO public.join_group_warehouse(group_code, warehouse_code, created_at, updated_at) VALUES (?, ?, ?, ?);', [$group_code, $warehouse_code, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                return 'success';
            } else {
                DB::connection('pgsql_od')->insert('INSERT INTO public.join_group_warehouse(group_code, warehouse_code, created_at, updated_at) VALUES (?, ?, ?, ?);', [$group_code, $warehouse_code, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
                return 'success';
            }
        } catch (\Throwable $th) {
            
        }   
    }

    public function delete_group_wh(Request $request)
    {
        $group_code = $request->group_code;
        $warehouse_code = $request->warehouse_code;
        $ch = $request->session()->get('choose-base');
        if ($ch == 'pp') {
            DB::connection('pgsql_pp')->insert('DELETE FROM join_group_warehouse WHERE group_code = ? AND warehouse_code = ?', [$group_code, $warehouse_code]);
            return 'success';
        } else {
            DB::connection('pgsql_od')->insert('DELETE FROM join_group_warehouse WHERE group_code = ? AND warehouse_code = ?', [$group_code, $warehouse_code]);
            return 'success';
        }
    }
    
    public function load_group_wh(Request $request)
    {
        $group_code = $request->group_code;
        $ch = $request->session()->get('choose-base');
       
        if ($ch == 'pp') {
            $data = DB::connection('pgsql_pp')->select('SELECT t1.code, t1.name_1 FROM ic_warehouse AS t1, join_group_warehouse AS t2
            WHERE t1.code = t2.warehouse_code AND t2.group_code = ?', [$group_code]);
        } else {
            $data = DB::connection('pgsql_od')->select('SELECT t1.code, t1.name_1 FROM ic_warehouse AS t1, join_group_warehouse AS t2
            WHERE t1.code = t2.warehouse_code AND t2.group_code = ?', [$group_code]);    
        }
        return response()->json($data);
    }

    public function load_warehouse(Request $request){
        $ch = $request->session()->get('choose-base');
        $group_code = $request->group_code;
        $ic_warehouse = array();
        if ($ch == 'pp') {
            $group_warehouse = DB::connection('pgsql_pp')->select('SELECT * FROM join_group_warehouse WHERE group_code = ?', [$group_code]);
            $ic_warehouse = DB::connection('pgsql_pp')->select('SELECT * FROM ic_warehouse');
        } else {
            $group_warehouse = DB::connection('pgsql_od')->select('SELECT * FROM join_group_warehouse WHERE group_code = ?', [$group_code]);
            $ic_warehouse = DB::connection('pgsql_od')->select('SELECT * FROM ic_warehouse');
        }
        return response()->json(['ic_warehouse'=>$ic_warehouse, 'group_warehouse'=>$group_warehouse]);
    }
}