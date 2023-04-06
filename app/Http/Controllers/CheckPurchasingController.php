<?php

namespace App\Http\Controllers;

use App\Models\InventoryUnit;
use App\Models\PurchasingInventory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CheckPurchasingController extends Controller
{
    public function load_data(Request $request)
    {
        

        $base = $request->session()->get('choose-base');
        if ($base == 'pp') {
            $db = Config::get('dbcon.ppdb');
        } else {
            $db = Config::get('dbcon.odiendb');
        }

        $purchasing = PurchasingInventory::join('crm_employee', 'crm_employee.id', 'ic_purchasing_inventory.creater')
            ->where(function($q){
                $q->where('ic_purchasing_inventory.ch_status', 1)
                ->orWhere('ic_purchasing_inventory.ch_status', 2)
                ->orWhere('ic_purchasing_inventory.ch_status', 3);
            })
            ->where('ic_purchasing_inventory.base', $base)
            ->select('ic_purchasing_inventory.doc_no', 'ic_purchasing_inventory.creater', 'crm_employee.emp_name', 'crm_employee.code_fb', 'ic_purchasing_inventory.ch_status')
            ->get();
            $product_data = array();
            $ip = Config::get('dbcon.ip_local');
            foreach ($purchasing as $key => $value) {
                $product = DB::select("SELECT t1.doc_no, t1.code, t1.name_1, t1.name_eng_1, t1.unit_standard, t2.name_1 AS ph1, t3.name_1 AS ph2, t4.name_1 AS ph3, t5.name_1 AS ph4, t6.name_1 AS ph5 , t7.name_1 AS ph6, t8.name_1 AS ph7, t9.name_1 AS ph8 FROM ic_inventory AS t1,
                (SELECT * FROM dblink('host = ".$ip." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group') AS t1(code text, name_1  text) ) AS t2,
                (SELECT * FROM dblink('host = ".$ip." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub') AS t1(code text, name_1  text) ) AS t3,
                (SELECT * FROM dblink('host = ".$ip." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub2') AS t1(code text, name_1  text) ) AS t4,
                (SELECT * FROM dblink('host = ".$ip." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_category') AS t1(code text, name_1  text) ) AS t5,
                (SELECT * FROM dblink('host = ".$ip." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_brand') AS t1(code text, name_1  text) ) AS t6,
                (SELECT * FROM dblink('host = ".$ip." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_pattern') AS t1(code text, name_1  text) ) AS t7,
                (SELECT * FROM dblink('host = ".$ip." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_size') AS t1(code text, name_1  text) ) AS t8,
                (SELECT * FROM dblink('host = ".$ip." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_design') AS t1(code text, name_1  text) ) AS t9
                WHERE t1.group_main = t2.code AND t1.group_sub = t3.code AND t1.group_sub2 = t4.code AND t1.item_category = t5.code AND
                t1.item_brand = t6.code AND t1.item_pattern = t7.code AND t1.item_size = t8.code AND t1.item_design = t9.code AND t1.doc_no = ? ORDER BY code ASC", [$value->doc_no]);
                $product_data[] = $product;
            }
        return response()->json(['purchasing'=>$purchasing,'product_data'=>$product_data]);
    }

    public function send_back_for_edit(Request $request)
    {
        $doc_no = $request->doc_no;
        $ch_date = date('Y-m-d H:i:s');
        $check_purchasing = DB::update("UPDATE public.ic_purchasing_inventory SET ch_date = ?, ch_status=0 WHERE doc_no=?", [$ch_date, $doc_no]);
        if ($check_purchasing) {
            return 'success';
        }
    }

    public function send_purchasing_to_accounting(Request $request)
    {
        $doc_no = $request->doc_no;
        $ch_date = date('Y-m-d H:i:s');
        $check_purchasing = DB::update("UPDATE public.ic_purchasing_inventory SET ch_date = ?, ch_status = 2 WHERE doc_no=?", [$ch_date, $doc_no]);
        if ($check_purchasing) {
            return 'success';
        }
    }

    public function approve_purchasing_inventory(Request $request)
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
        $ip = Config::get('dbcon.ip_local');
        $doc_no = $request->doc_no;
        $sql = "SELECT t1.doc_no, t1.code, t1.name_1, t1.unit_standard, t2.name_1 AS ph1, t3.name_1 AS ph2, t4.name_1 AS ph3, t5.name_1 AS ph4, t6.name_1 AS ph5 , t7.name_1 AS ph6, t8.name_1 AS ph7, t9.name_1 AS ph8 FROM ic_inventory AS t1,
        (SELECT * FROM dblink('host = ". $ip. " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group') AS t1(code text, name_1  text) ) AS t2,
        (SELECT * FROM dblink('host = ". $ip. " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub') AS t1(code text, name_1  text) ) AS t3,
        (SELECT * FROM dblink('host = ". $ip. " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub2') AS t1(code text, name_1  text) ) AS t4,
        (SELECT * FROM dblink('host = ". $ip. " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_category') AS t1(code text, name_1  text) ) AS t5,
        (SELECT * FROM dblink('host = ". $ip. " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_brand') AS t1(code text, name_1  text) ) AS t6,
        (SELECT * FROM dblink('host = ". $ip. " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_pattern') AS t1(code text, name_1  text) ) AS t7,
        (SELECT * FROM dblink('host = ". $ip. " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_size') AS t1(code text, name_1  text) ) AS t8,
        (SELECT * FROM dblink('host = ". $ip. " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_design') AS t1(code text, name_1  text) ) AS t9
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

    public function confirm_approve_purchasing(Request $request)
    {
        $doc_no = $request->doc_no;
        $ch_date = date('Y-m-d H:i:s');
        $check_purchasing = DB::update("UPDATE public.ic_purchasing_inventory SET ch_date = ?, ch_status = 4 WHERE doc_no=?", [$ch_date, $doc_no]);
        if ($check_purchasing) {
            return 'success';
        }
    }
}