<?php

namespace App\Http\Controllers\ManageData;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDesignController extends Controller
{
    public function index(Request $request)
    {
        $ch = $request->session()->get('choose-base');
        //ic category
        $api = new ApiController();
        if ($ch == 'pp') {
            $ic_category = $api->load_category('pp');
        } else {
            $ic_category = $api->load_category('od');
        }
        
        return view('manage-data.product-design', compact('ic_category'));
    }

    public function insert_cate_design(Request $request)
    {
        try {
            $design_code = $request->design_code;
            $cate_code = $request->cate_code;
            $ch = $request->session()->get('choose-base');
            if ($ch == 'pp') {
                DB::connection('pgsql_pp')->insert('INSERT INTO join_cate_design (category_code, design_code) VALUES (?, ?)', [$cate_code, $design_code]);
                return 'success';
            } else {
                DB::connection('pgsql_od')->insert('INSERT INTO join_cate_design (category_code, design_code) VALUES (?, ?)', [$cate_code, $design_code]);
                return 'success';
            }
        } catch (\Throwable $th) {
            
        }   
    }

    public function delete_cate_design(Request $request)
    {
        $design_code = $request->design_code;
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
        if ($ch == 'pp') {
            DB::connection('pgsql_pp')->insert('DELETE FROM join_cate_design WHERE category_code = ? AND design_code = ?', [$cate_code, $design_code]);
            return 'success';
        } else {
            DB::connection('pgsql_od')->insert('DELETE FROM join_cate_design WHERE category_code = ? AND design_code = ?', [$cate_code, $design_code]);
            return 'success';
        }
    }
    
    public function load_cate_design(Request $request)
    {
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
       
        if ($ch == 'pp') {
            $data = DB::connection('pgsql_pp')->select('SELECT t2.code, t2.name_1 FROM join_cate_design t1, ic_design t2 WHERE 
            t1.design_code = t2.code AND t1.category_code = ?', [$cate_code]);
        } else {
            $data = DB::connection('pgsql_od')->select('SELECT t2.code, t2.name_1 FROM join_cate_design t1, ic_design t2 WHERE 
            t1.design_code = t2.code AND t1.category_code = ?', [$cate_code]);
        }
        return $data;
    }

    public function load_design(Request $request){
        $ch = $request->session()->get('choose-base');
        $cate_code = $request->cate_code;
        $ic_design = array();
        if ($ch == 'pp') {
            $cate_design = DB::connection('pgsql_pp')->select('SELECT * FROM join_cate_design WHERE category_code = ?', [$cate_code]);
            $ic_design = DB::connection('pgsql_pp')->select('SELECT * FROM ic_design');
        } else {
            $cate_design = DB::connection('pgsql_od')->select('SELECT * FROM join_cate_design WHERE category_code = ?', [$cate_code]);
            $ic_design = DB::connection('pgsql_od')->select('SELECT * FROM ic_design');
        }

        return response()->json(['ic_design'=>$ic_design, 'cate_design'=>$cate_design]);
    }
}