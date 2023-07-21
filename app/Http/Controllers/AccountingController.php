<?php

namespace App\Http\Controllers;

use App\Models\PurchasingInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Phattarachai\LineNotify\Facade\Line;

class AccountingController extends Controller
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
            ->where('ic_purchasing_inventory.ch_status', 2)
            ->where('ic_purchasing_inventory.base', $base)
            ->select('ic_purchasing_inventory.doc_no', 'ic_purchasing_inventory.creater', 'crm_employee.emp_name', 'crm_employee.code_fb')
            ->get();
            $product_data = array();
            $ip = Config::get('dbcon.ip_local');
            $port = Config::get('dbcon.port');
            foreach ($purchasing as $key => $value) {
                $product = DB::select("SELECT t1.pi_no, t1.doc_no, t1.code, t1.name_1, t1.unit_standard, t2.name_1 AS ph1, t3.name_1 AS ph2, t4.name_1 AS ph3, t5.name_1 AS ph4, t6.name_1 AS ph5 , t7.name_1 AS ph6, t8.name_1 AS ph7, t9.name_1 AS ph8, t1.account_code_1 , t1.account_code_2, t1.account_code_3, t1.account_code_4
                FROM ic_inventory AS t1,
                (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group') AS t1(code text, name_1  text) ) AS t2,
                (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub') AS t1(code text, name_1  text) ) AS t3,
                (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub2') AS t1(code text, name_1  text) ) AS t4,
                (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_category') AS t1(code text, name_1  text) ) AS t5,
                (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_brand') AS t1(code text, name_1  text) ) AS t6,
                (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_pattern') AS t1(code text, name_1  text) ) AS t7,
                (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_size') AS t1(code text, name_1  text) ) AS t8,
                (SELECT * FROM dblink('host = ". $ip ." user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_design') AS t1(code text, name_1  text) ) AS t9
                WHERE t1.group_main = t2.code AND t1.group_sub = t3.code AND t1.group_sub2 = t4.code AND t1.item_category = t5.code AND
                t1.item_brand = t6.code AND t1.item_pattern = t7.code AND t1.item_size = t8.code AND t1.item_design = t9.code AND t1.doc_no = ? ORDER BY code ASC", [$value->doc_no]);
                $product_data[] = $product;
            }
        return response()->json(['purchasing'=>$purchasing,'product_data'=>$product_data]);
    }

    public function load_chat_of_account(Request $request)
    {
        $base = $request->session()->get('choose-base');
        if ($base == 'pp') {
            $sql = "SELECT code, name_1, name_2, main_code, account_group FROM public.gl_chart_of_account;";
            $chat_of_account = DB::connection('pgsql_pp')->select($sql);
        } else {
            $sql = "SELECT code, name_1, name_2, main_code, account_group FROM public.gl_chart_of_account;";
            $chat_of_account = DB::connection('pgsql_od')->select($sql);
        }
        return response()->json($chat_of_account);
    }

    public function add_chat_account_to_pur(Request $request)
    {
        $index = $request->ac_index;
        $ac_code = $request->ac_code;
        $pi_no = $request->pi_no;
        if ($index == 1) {
            $sql = "UPDATE public.ic_inventory SET account_code_1='$ac_code' WHERE pi_no = '$pi_no'";
        } else if($index == 2){
            $sql = "UPDATE public.ic_inventory SET account_code_2='$ac_code' WHERE pi_no = '$pi_no'";
        } else if($index == 3){
            $sql = "UPDATE public.ic_inventory SET account_code_3='$ac_code' WHERE pi_no = '$pi_no'";
        } else if($index == 4){
            $sql = "UPDATE public.ic_inventory SET account_code_4='$ac_code' WHERE pi_no = '$pi_no'";
        }
        DB::update($sql);
        return response()->json('success');
    }

    public function confirm_add_account(Request $request)
    {
        $doc_no = $request->doc_no;
        $ch_date = date('Y-m-d H:i:s');
        $check_purchasing = DB::update("UPDATE public.ic_purchasing_inventory SET ch_date = ?, ch_status = 4 WHERE doc_no=?", [$ch_date, $doc_no]);
        if ($check_purchasing) {
            line::send('@oranong ອັບຂື້ນລະບົບໃຫ້ແນ່ :'. $doc_no);
            return 'success';
        }
    }
}
