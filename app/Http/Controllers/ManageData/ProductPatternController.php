<?php

namespace App\Http\Controllers\ManageData;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductPatternController extends Controller
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
        return view('manage-data.product-pattern', compact('ic_category'));
    }

    public function insert_cate_pattern(Request $request)
    {
        try {
            $pattern_code = $request->pattern_code;
            $cate_code = $request->cate_code;
            $ch = $request->session()->get('choose-base');
            if ($ch == 'pp') {
                DB::connection('pgsql_pp')->insert('INSERT INTO join_cate_pattern (category_code, pattern_code) VALUES (?, ?)', [$cate_code, $pattern_code]);
                return 'success';
            } else {
                DB::connection('pgsql_od')->insert('INSERT INTO join_cate_pattern (category_code, pattern_code) VALUES (?, ?)', [$cate_code, $pattern_code]);
                return 'success';
            }
        } catch (\Throwable $th) {
            
        }   
    }

    public function delete_cate_pattern(Request $request)
    {
        $pattern_code = $request->pattern_code;
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
        if ($ch == 'pp') {
            DB::connection('pgsql_pp')->insert('DELETE FROM join_cate_pattern WHERE category_code = ? AND pattern_code = ?', [$cate_code, $pattern_code]);
            return 'success';
        } else {
            DB::connection('pgsql_od')->insert('DELETE FROM join_cate_pattern WHERE category_code = ? AND pattern_code = ?', [$cate_code, $pattern_code]);
            return 'success';
        }
    }
    
    public function load_cate_pattern(Request $request)
    {
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
       
        if ($ch == 'pp') {
            $data = DB::connection('pgsql_pp')->select('SELECT t2.code, t2.name_1 FROM join_cate_pattern t1, ic_pattern t2 WHERE 
            t1.pattern_code = t2.code AND t1.category_code = ?', [$cate_code]);
        } else {
            $data = DB::connection('pgsql_od')->select('SELECT t2.code, t2.name_1 FROM join_cate_pattern t1, ic_pattern t2 WHERE 
            t1.pattern_code = t2.code AND t1.category_code = ?', [$cate_code]);
        }
        return $data;
    }

    public function load_pattern(Request $request){
        $ch = $request->session()->get('choose-base');
        $cate_code = $request->cate_code;
        $ic_pattern = array();
        if ($ch == 'pp') {
            $cate_pattern = DB::connection('pgsql_pp')->select('SELECT * FROM join_cate_pattern WHERE category_code = ?', [$cate_code]);
            $ic_pattern = DB::connection('pgsql_pp')->select('SELECT * FROM ic_pattern');
        } else {
            $cate_pattern = DB::connection('pgsql_od')->select('SELECT * FROM join_cate_pattern WHERE category_code = ?', [$cate_code]);
            $ic_pattern = DB::connection('pgsql_od')->select('SELECT * FROM ic_pattern');
        }

        return response()->json(['ic_pattern'=>$ic_pattern, 'cate_pattern'=>$cate_pattern]);
    }
}