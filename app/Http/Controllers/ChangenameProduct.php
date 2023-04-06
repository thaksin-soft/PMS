<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChangenameProduct extends Controller
{
    public function index(request $request)
    {
        // $base = $request->session()->get('choose-base');
        // if ($base == 'pp') {
        //         $sql = DB::connection('pgsql_pp')->select("SELECT code,name_1,name_2,name_eng_1,unit_standard,CASE WHEN code in((SELECT item_code FROM ic_trans_detail where trans_flag in('12','310','44','48') and item_code = a.code  GROUP BY item_code)) THEN '1' ELSE '0' END as check_trans FROM ic_inventory a");
        // } else {
        //     $sql = DB::connection('pgsql_od')->select("SELECT code,name_1,name_2,name_eng_1,unit_standard,CASE WHEN code in((SELECT item_code FROM ic_trans_detail where trans_flag in('12','310','44','48') and item_code = a.code  GROUP BY item_code)) THEN '1' ELSE '0' END as check_trans FROM ic_inventory a");
        // }

        return view('manage-data.change-nameproduct.index');
    }
    
    public function product_list(request $request){
        $base = $request->session()->get('choose-base');
        if ($base == 'pp') {

            if($request->ajax())
                    { $output = '';
                    $query = $request->get('query');
                    if($query != '')
                            {
                            
                            $data_sql = DB::connection('pgsql_pp')->select("select code,name_1,unit_standard,item_brand,CASE WHEN code in(select code from dblink('host=192.168.0.129 port=5432 user=postgres password=sml dbname=od_test','select code from ic_inventory') t1 (code text)) THEN '1' ELSE '0' END as check_code FROM ic_inventory where manufacturer_code !='pp'
                            and code like '%$query%' or name_1 like '%$query%' or item_brand like '%$query%' ");

                    echo json_encode($data_sql);
                    }
            }
        }else{

            if($request->ajax())
            { $output = '';
            $query = $request->get('query');
            if($query != '')
                    {
                    
                    $data_sql = DB::connection('pgsql_od')->select("select code,name_1,unit_standard,item_brand,CASE WHEN code in(select code from dblink('host=192.168.0.129 port=5432 user=postgres password=sml dbname=t_test','select code from ic_inventory') t1 (code text)) THEN '1' ELSE '0' END as check_code FROM ic_inventory where manufacturer_code !='odien'
                    and code like '%$query%' or name_1 like '%$query%' or item_brand like '%$query%' ");

            echo json_encode($data_sql);
            }
            
        }
     }
}

}
