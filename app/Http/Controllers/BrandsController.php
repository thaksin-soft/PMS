<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\ic_Brand;

class BrandsController extends Controller
{
    public function index(request $request)
    {
        $brand = ic_brand::orderby('create_date_time_now','DESC')->get();
        return view('manage-data.brands.index',compact('brand'));
    }

    public function create(request $request)
    {
        return view('manage-data.brands.create');
    }
    public function save(request $request)
    {
        $code = $request->code;
        $name_1 = $request->name_1;
        $name_2 = $request->name_2;

        $sql = DB::insert("insert into ic_brand (code, name_1) values ('$code', '$name_1')");

        if($sql){
            $sqlodmall = DB::connection('pgsql_odmall')->insert("insert into ic_brand (code, name_1) values ('$code', '$name_1')");

                if($sqlodmall){
                    $sql_pp = DB::connection('pgsql_pp')->insert("insert into ic_brand (code, name_1) values ('$code', '$name_1')");
                    if($sql_pp){
                        $sql_od = DB::connection('pgsql_od')->insert("insert into ic_brand (code, name_1) values ('$code', '$name_1')");

                        if($sql_od){
                            return redirect()->route('brands-index')->with('success','create brand successfull');
                        }
                    }
                }
                
            }
    }
}

