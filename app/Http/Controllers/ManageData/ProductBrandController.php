<?php

namespace App\Http\Controllers\ManageData;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBrandController extends Controller
{
    public function index(Request $request)
    {
        //ic_brand
        $ch = $request->session()->get('choose-base');
        /* if ($ch == 'pp') {
            $ic_brand = DB::connection('pgsql_pp')->select('SELECT * FROM ic_brand');
        } else {
            $ic_brand = DB::connection('pgsql_od')->select('SELECT * FROM ic_brand');
        } */
        
        //ic category
        $api = new ApiController();
        if ($ch == 'pp') {
            $ic_category = $api->load_category('pp');
        } else {
            $ic_category = $api->load_category('od');
        }
        
        return view('manage-data.product-brand', compact('ic_category'));
    }

    public function insert_cate_brand(Request $request)
    {
        try {
            $brand_code = $request->brand_code;
            $cate_code = $request->cate_code;
            $ch = $request->session()->get('choose-base');
            if ($ch == 'pp') {
                DB::connection('pgsql_pp')->insert('INSERT INTO join_cate_brand (category_code, brand_code) VALUES (?, ?)', [$cate_code, $brand_code]);
                return 'success';
            } else {
                DB::connection('pgsql_od')->insert('INSERT INTO join_cate_brand (category_code, brand_code) VALUES (?, ?)', [$cate_code, $brand_code]);
                return 'success';
            }
        } catch (\Throwable $th) {
            
        }   
    }

    public function delete_cate_brand(Request $request)
    {
        $brand_code = $request->brand_code;
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
        if ($ch == 'pp') {
            DB::connection('pgsql_pp')->insert('DELETE FROM join_cate_brand WHERE category_code = ? AND brand_code = ?', [$cate_code, $brand_code]);
            return 'success';
        } else {
            DB::connection('pgsql_od')->insert('DELETE FROM join_cate_brand WHERE category_code = ? AND brand_code = ?', [$cate_code, $brand_code]);
            return 'success';
        }
    }
    
    public function load_cate_brand(Request $request)
    {
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
       
        if ($ch == 'pp') {
            $data = DB::connection('pgsql_pp')->select('SELECT t2.code, t2.name_1 FROM join_cate_brand t1, ic_brand t2 WHERE 
            t1.brand_code = t2.code AND t1.category_code = ?', [$cate_code]);
        } else {
            $data = DB::connection('pgsql_od')->select('SELECT t2.code, t2.name_1 FROM join_cate_brand t1, ic_brand t2 WHERE 
            t1.brand_code = t2.code AND t1.category_code = ?', [$cate_code]);
        }
       
        return response()->json($data);
    }

    public function load_brand(Request $request){
        $ch = $request->session()->get('choose-base');
        $cate_code = $request->cate_code;
        $ic_brand = array();
        if ($ch == 'pp') {
            $cate_brand = DB::connection('pgsql_pp')->select('SELECT * FROM join_cate_brand WHERE category_code = ?', [$cate_code]);
            $ic_brand = DB::connection('pgsql_pp')->select('SELECT * FROM ic_brand');
        } else {
            $cate_brand = DB::connection('pgsql_od')->select('SELECT * FROM join_cate_brand WHERE category_code = ?', [$cate_code]);
            $ic_brand = DB::connection('pgsql_od')->select('SELECT * FROM ic_brand');
        }

        return response()->json(['ic_brand'=>$ic_brand, 'cate_brand'=>$cate_brand]);
    }

}