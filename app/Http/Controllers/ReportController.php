<?php

namespace App\Http\Controllers;

use App\Models\PurchasingInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ReportController extends Controller
{
    public function report_product_uploaded(Request $request)
    {
        $base = $request->session()->get('choose-base');
        $emp = auth()->user()->emp_id;
        $product_upload = PurchasingInventory::where('ch_status', 5)
            ->where('base', $base)
            ->get();
        
        return view('reports.report-product-uploaded', compact('product_upload'));
    }

    public function report_new_product(Request $request)
    {
        # code...
    }

    public function show_product_uploaded(Request $request)
    {
        $doc_no = $request->doc_no;
        return view('purchasing.approve-purchasing', compact('doc_no'));
    }
    public function load_data_print(Request $request)
    {
        $base = $request->session()->get('choose-base');
        if ($base == 'pp') {
            $db = Config::get('dbcon.ppdb');
        } else {
            $db = Config::get('dbcon.odiendb');
        }
        $doc_no = $request->doc_no;
        $ip = Config::get('dbcon.ip_local');
        $sql = "SELECT t1.doc_no, t1.code, t1.name_1, t1.unit_standard, t2.name_1 AS ph1, t3.name_1 AS ph2, t4.name_1 AS ph3, t5.name_1 AS ph4, t6.name_1 AS ph5 , t7.name_1 AS ph6, t8.name_1 AS ph7, t9.name_1 AS ph8 FROM ic_inventory AS t1,
        (SELECT * FROM dblink('host = ". $ip ." = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group') AS t1(code text, name_1  text) ) AS t2,
        (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub') AS t1(code text, name_1  text) ) AS t3,
        (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub2') AS t1(code text, name_1  text) ) AS t4,
        (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_category') AS t1(code text, name_1  text) ) AS t5,
        (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_brand') AS t1(code text, name_1  text) ) AS t6,
        (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_pattern') AS t1(code text, name_1  text) ) AS t7,
        (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_size') AS t1(code text, name_1  text) ) AS t8,
        (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_design') AS t1(code text, name_1  text) ) AS t9
        WHERE t1.group_main = t2.code AND t1.group_sub = t3.code AND t1.group_sub2 = t4.code AND t1.item_category = t5.code AND
        t1.item_brand = t6.code AND t1.item_pattern = t7.code AND t1.item_size = t8.code AND t1.item_design = t9.code AND t1.doc_no = '$doc_no' ORDER BY code ASC";
        $product = DB::select($sql);
        //
        $purchasing = PurchasingInventory::join('crm_employee', 'crm_employee.id', 'ic_purchasing_inventory.creater')
            ->where('ic_purchasing_inventory.doc_no', $doc_no)
            ->select('ic_purchasing_inventory.doc_no', 'ic_purchasing_inventory.creater', 'crm_employee.emp_name', 'crm_employee.code_fb', 'ic_purchasing_inventory.in_date')
            ->get();
        //
        $checker = DB::select("SELECT * FROM public.crm_employee WHERE id = ?", [auth()->user()->emp_id]);
        return response()->json(['base'=>$base, 'product'=>$product, 'purchasing'=>$purchasing, 'checker'=>$checker]);
    }
}