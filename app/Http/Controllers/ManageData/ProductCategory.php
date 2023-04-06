<?php

namespace App\Http\Controllers\ManageData;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Controller
{
    public function index(Request $request)
    {
        $ch = $request->session()->get('choose-base');
        //ic category
        if ($ch == 'pp') {
            $group_sub2 = DB::connection('pgsql_pp')->select('SELECT * FROM public.ic_group_sub2');
        } else {
            $group_sub2 = DB::connection('pgsql_od')->select('SELECT * FROM public.ic_group_sub2');
        }
        return view('manage-data.product-category', compact('group_sub2'));
    }

    public function insert_product_category(Request $request)
    {
        try {
            $category_code = $request->category_code;
            $sub2_code = $request->sub2_code;
            $ch = $request->session()->get('choose-base');
            if ($ch == 'pp') {
                DB::connection('pgsql_pp')->insert('INSERT INTO join_sub2_cate (sub2_code, category_code) VALUES (?, ?)', [$sub2_code, $category_code]);
                return 'success';
            } else {
                DB::connection('pgsql_od')->insert('INSERT INTO join_sub2_cate (sub2_code, category_code) VALUES (?, ?)', [$sub2_code, $category_code]);
                return 'success';
            }
        } catch (\Throwable $th) {
            
        }   
    }

    public function delete_product_category(Request $request)
    {
        $category_code = $request->category_code;
        $sub2_code = $request->sub2_code;
        $ch = $request->session()->get('choose-base');
        if ($ch == 'pp') {
            DB::connection('pgsql_pp')->insert('DELETE FROM join_sub2_cate WHERE sub2_code = ? AND category_code = ?', [$sub2_code, $category_code]);
            return 'success';
        } else {
            DB::connection('pgsql_od')->insert('DELETE FROM join_sub2_cate WHERE sub2_code = ? AND category_code = ?', [$sub2_code, $category_code]);
            return 'success';
        }
    }
    
    public function load_product_category(Request $request)
    {
        $sub2_code = $request->sub2_code;
        $ch = $request->session()->get('choose-base');
       
        if ($ch == 'pp') {
            $data = DB::connection('pgsql_pp')->select('SELECT t2.code, t2.name_1 FROM join_sub2_cate t1, ic_category t2 WHERE 
            t1.category_code = t2.code AND t1.sub2_code = ?', [$sub2_code]);
        } else {
            $data = DB::connection('pgsql_od')->select('SELECT t2.code, t2.name_1 FROM join_sub2_cate t1, ic_category t2 WHERE 
            t1.category_code = t2.code AND t1.sub2_code = ?', [$sub2_code]);    
        }
       
        return response()->json($data);
    }

    public function load_category(Request $request){
        $ch = $request->session()->get('choose-base');
        $sub2_code = $request->sub2_code;
        $ic_category = array();
        if ($ch == 'pp') {
            $product_category = DB::connection('pgsql_pp')->select('SELECT * FROM join_sub2_cate WHERE sub2_code = ?', [$sub2_code]);
            $ic_category = DB::connection('pgsql_pp')->select('SELECT * FROM ic_category');
        } else {
            $product_category = DB::connection('pgsql_od')->select('SELECT * FROM join_sub2_cate WHERE sub2_code = ?', [$sub2_code]);
            $ic_category = DB::connection('pgsql_od')->select('SELECT * FROM ic_category');
        }

        return response()->json(['ic_category'=>$ic_category, 'product_category'=>$product_category]);
    }
}