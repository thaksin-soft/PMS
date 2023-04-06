<?php

namespace App\Http\Controllers\ManageData;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductSizeController extends Controller
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
        return view('manage-data.product-size', compact('ic_category'));
    }

    public function insert_cate_size(Request $request)
    {
        try {
            $size_code = $request->size_code;
            $cate_code = $request->cate_code;
            $ch = $request->session()->get('choose-base');
            if ($ch == 'pp') {
                DB::connection('pgsql_pp')->insert('INSERT INTO join_cate_size (category_code, size_code) VALUES (?, ?)', [$cate_code, $size_code]);
                return 'success';
            } else {
                DB::connection('pgsql_od')->insert('INSERT INTO join_cate_size (category_code, size_code) VALUES (?, ?)', [$cate_code, $size_code]);
                return 'success';
            }
        } catch (\Throwable $th) {
            
        }   
    }

    public function delete_cate_size(Request $request)
    {
        $size_code = $request->size_code;
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
        if ($ch == 'pp') {
            DB::connection('pgsql_pp')->insert('DELETE FROM join_cate_size WHERE category_code = ? AND size_code = ?', [$cate_code, $size_code]);
            return 'success';
        } else {
            DB::connection('pgsql_od')->insert('DELETE FROM join_cate_size WHERE category_code = ? AND size_code = ?', [$cate_code, $size_code]);
            return 'success';
        }
    }
    
    public function load_cate_size(Request $request)
    {
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
       
        if ($ch == 'pp') {
            $data = DB::connection('pgsql_pp')->select('SELECT t2.code, t2.name_1 FROM join_cate_size t1, ic_size t2 WHERE 
            t1.size_code = t2.code AND t1.category_code = ?', [$cate_code]);
        } else {
            $data = DB::connection('pgsql_od')->select('SELECT t2.code, t2.name_1 FROM join_cate_size t1, ic_size t2 WHERE 
            t1.size_code = t2.code AND t1.category_code = ?', [$cate_code]);
        }
        return $data;
    }

    public function load_size(Request $request){
        $ch = $request->session()->get('choose-base');
        $cate_code = $request->cate_code;
        $ic_size = array();
        if ($ch == 'pp') {
            $cate_size = DB::connection('pgsql_pp')->select('SELECT * FROM join_cate_size WHERE category_code = ?', [$cate_code]);
            $ic_size = DB::connection('pgsql_pp')->select('SELECT * FROM ic_size');
        } else {
            $cate_size = DB::connection('pgsql_od')->select('SELECT * FROM join_cate_size WHERE category_code = ?', [$cate_code]);
            $ic_size = DB::connection('pgsql_od')->select('SELECT * FROM ic_size');
        }

        return response()->json(['ic_size'=>$ic_size, 'cate_size'=>$cate_size]);
    }
}