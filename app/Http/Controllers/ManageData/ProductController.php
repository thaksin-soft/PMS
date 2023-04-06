<?php
namespace App\Http\Controllers\ManageData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $ch = $request->session()->get('choose-base');
        //ic category
        if ($ch == 'pp') {
            $ic_category = DB::connection('pgsql_pp')->select('SELECT * FROM public.ic_category');
        } else {
            $ic_category = DB::connection('pgsql_od')->select('SELECT * FROM public.ic_category');
        }
        return view('manage-data.product', compact('ic_category'));
    }

    public function insert_product(Request $request)
    {
        try {
            $category_code = $request->category_code;
            $product_code = $request->product_code;
            $product_name = $request->product_name;
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            
            $ch = $request->session()->get('choose-base');
            if ($ch == 'pp') {
                DB::connection('pgsql_pp')->insert('INSERT INTO public.join_products(
                    category_code, product_code, product_name, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', [$category_code, $product_code, $product_name, $created_at, $updated_at]);
                return 'success';
            } else {
                DB::connection('pgsql_od')->insert('INSERT INTO public.join_products(
                    category_code, product_code, product_name, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', [$category_code, $product_code, $product_name, $created_at, $updated_at]);
                return 'success';
            }
        } catch (\Throwable $th) {
            
        }   
    }

    public function delete_product(Request $request)
    {
        $product_code = $request->product_code;
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
        if ($ch == 'pp') {
            DB::connection('pgsql_pp')->insert('DELETE FROM join_products WHERE category_code = ? AND product_code = ?', [$cate_code, $product_code]);
            return 'success';
        } else {
            DB::connection('pgsql_od')->insert('DELETE FROM join_products WHERE category_code = ? AND product_code = ?', [$cate_code, $product_code]);
            return 'success';
        }
    }
    
    public function load_product(Request $request)
    {
        $cate_code = $request->cate_code;
        $ch = $request->session()->get('choose-base');
       
        if ($ch == 'pp') {
            $data = DB::connection('pgsql_pp')->select('SELECT product_code, product_name FROM public.join_products WHERE category_code = ?', [$cate_code]);
        } else {
            $data = DB::connection('pgsql_od')->select('SELECT product_code, product_name FROM public.join_products WHERE category_code = ?', [$cate_code]);
        }
       
        return response()->json($data);
    }

    public function edit_product(Request $request)
    {
        $ch = $request->session()->get('choose-base');
        $product_name = $request->name;
        $product_code = $request->code;
        if ($ch == 'pp') {
            DB::connection('pgsql_pp')->select('UPDATE public.join_products SET product_name= ? WHERE product_code= ?', [$product_name, $product_code]);
            return 'success';
        } else {
            DB::connection('pgsql_od')->select('UPDATE public.join_products SET product_name= ? WHERE product_code= ?', [$product_name, $product_code]);
            return 'success';
        }
    }

}