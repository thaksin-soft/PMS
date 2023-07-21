<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Models\InventoryDetail;
use App\Models\InventoryUnit;
use App\Models\PurchasingInventory;
use Illuminate\Support\Facades\Config;
use Phattarachai\LineNotify\Facade\Line;

class PurchasingController extends Controller
{
    public function delete_purchasing(Request $request)
    {
        $doc_no = $request->doc_no;
        PurchasingInventory::where('doc_no', $doc_no)->delete();
        Inventory::where('doc_no', $doc_no)->delete();
        InventoryDetail::where('doc_no', $doc_no)->delete();
        return 'success';
    }

    public function save_purchasing(Request $request)
    {
        $base = $request->session()->get('choose-base');
        $doc_no = date('ymdHis');
        $purch_inv = new PurchasingInventory();
        $purch_inv->doc_no = $doc_no;
        $purch_inv->in_date = date('Y-m-d H:i:s');
        $purch_inv->ch_date = null;
        $purch_inv->ch_status = 0;
        $purch_inv->up_status = 0;
        $purch_inv->creater = auth()->user()->emp_id;
        $purch_inv->approver = null;
        $purch_inv->uploader = null;
        $purch_inv->base = $base;
        $purch_inv->save();
        if($purch_inv){
            line::send('ສ້າງເອກະສານໃໝ່ :'.$doc_no);
        }
        return redirect()->back();
    }

    public function load_brand_pattern_size_design(Request $request)
    {
        $cate_code = $request->cate_code;
        $base = $request->session()->get('choose-base');

        if ($base == 'pp') {
            $brand = DB::connection('pgsql_pp')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_brand t1, join_cate_brand t2
            WHERE t1.code = t2.brand_code AND t2.category_code = ?', [$cate_code]);
            //
            $pattern = DB::connection('pgsql_pp')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_pattern t1, join_cate_pattern t2
            WHERE t1.code = t2.pattern_code AND t2.category_code = ?', [$cate_code]);
            //
            $size = DB::connection('pgsql_pp')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_size t1, join_cate_size t2
            WHERE t1.code = t2.size_code AND t2.category_code = ?', [$cate_code]);
            //
            $design = DB::connection('pgsql_pp')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_design t1, join_cate_design t2
            WHERE t1.code = t2.design_code AND t2.category_code = ?', [$cate_code]);
            //
            $product = DB::connection('pgsql_pp')->select('SELECT category_code, product_code, product_name, created_at, updated_at
            FROM public.join_products WHERE category_code = ?', [$cate_code]);


            return response()->json(['brand'=>$brand, 'pattern'=>$pattern, 'size'=>$size, 'design'=>$design, 'product'=>$product]);
        } else {
            $brand = DB::connection('pgsql_od')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_brand t1, join_cate_brand t2
            WHERE t1.code = t2.brand_code AND t2.category_code = ?', [$cate_code]);
            //
            $pattern = DB::connection('pgsql_od')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_pattern t1, join_cate_pattern t2
            WHERE t1.code = t2.pattern_code AND t2.category_code = ?', [$cate_code]);
            //
            $size = DB::connection('pgsql_od')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_size t1, join_cate_size t2
            WHERE t1.code = t2.size_code AND t2.category_code = ?', [$cate_code]);
            //
            $design = DB::connection('pgsql_od')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_design t1, join_cate_design t2
            WHERE t1.code = t2.design_code AND t2.category_code = ?', [$cate_code]);
            //
            $product = DB::connection('pgsql_od')->select('SELECT category_code, product_code, product_name, created_at, updated_at
            FROM public.join_products WHERE category_code = ?', [$cate_code]);


            return response()->json(['brand'=>$brand, 'pattern'=>$pattern, 'size'=>$size, 'design'=>$design, 'product'=>$product]);
        }
    }

    public function create_code(Request $request)
    {
        $base = $request->session()->get('choose-base');

        // $load_id = DB::select("SELECT right(max(code), 4) as maxid FROM ic_inventory WHERE left (code, 5) = ?", [$code_sub2]);
        // $load_last_id = $load_id[0]->maxid;
        // if ($load_last_id == '') {
        //     if ($base == 'pp') {
        //         $load_id = DB::connection('pgsql_pp')->select('SELECT right(max(code), 4) as maxid FROM ic_inventory WHERE left (code, 5) = ?', [$code_sub2]);
        //     } else {
        //         $load_id = DB::connection('pgsql_od')->select('SELECT right(max(code), 4) as maxid FROM ic_inventory WHERE left (code, 5) = ?', [$code_sub2]);
        //     }
        //     $load_last_id = $load_id[0]->maxid;
        //}
        $code_sub2 = $request->sub2;


        $load_id = DB::select("SELECT right(max(code), 4) as maxid FROM max_ic_code WHERE left (code, 5) ='$code_sub2'");

        $load_last_id = $load_id[0]->maxid;


        $max_id = $load_last_id + 1;
        if ($max_id < 10) {
            $code = '000' . $max_id;
        } else if ($max_id < 100) {
            $code = '00' . $max_id;
        } else if ($max_id < 1000) {
            $code = '0' . $max_id;
        } else {
            $code = $max_id;
        }
        $inventory_code = $code_sub2 . '-'. $code;
        //
        if ($base == 'pp') {
            $product_category = DB::connection('pgsql_pp')->select('SELECT t2.code, t2.name_1 FROM join_sub2_cate AS t1, ic_category AS t2 WHERE t1.category_code = t2.code AND t1.sub2_code = ?',[$code_sub2]);
        } else {
            $product_category = DB::connection('pgsql_od')->select('SELECT t2.code, t2.name_1 FROM join_sub2_cate AS t1, ic_category AS t2 WHERE t1.category_code = t2.code AND t1.sub2_code = ?', [$code_sub2]);
        }
        return response()->json(['inventory_code'=>$inventory_code, 'product_category'=>$product_category]);
    }

    public function save_pur_product(Request $request)
    {
        //ກວດສອບຊື່ສິນຄ້າກ່ອນບັນທຶກ
        //$ch = Inventory::where('name_1', $request->name_1)->get();
       // if (count($ch) > 0) {
       //     return 'exit';
      //  }

	// 	 //generate inventory code
    //     $base = $request->session()->get('choose-base');
    //     $ch = DB::select("SELECT a.name_1 FROM ic_inventory a
    //     INNER JOIN ic_purchasing_inventory b ON a.doc_no = b.doc_no
    //     where a.name_1 = '$request->name_1' and b.base='$base'");
	// 	 if (count($ch) > 0) {
    //       return 'exit';
    //    }

    //     //generate inventory code
    //
    //     $code_sub2 = $request->group_sub2;
    //     $load_id = DB::select("SELECT right(max(t1.code), 4) as maxid
    //     FROM ic_inventory t1, ic_purchasing_inventory t2
    //     WHERE left (t1.code, 5) = ? AND t1.doc_no = t2.doc_no", [$code_sub2]);
    //     $load_last_id = $load_id[0]->maxid;

//     $code_sub2 = $request->group_sub2;
//     $base = $request->session()->get('choose-base');

//             if ($base == 'pp') {
//                 $load_id = DB::connection('pgsql_pp')->select('SELECT right(max(code), 4) as maxid FROM ic_inventory WHERE left (code, 5) = ?', [$code_sub2]);
//             } else {
//                 $load_id = DB::connection('pgsql_od')->select('SELECT right(max(code), 4) as maxid FROM ic_inventory WHERE left (code, 5) = ?', [$code_sub2]);
//             }
//             $load_last_id = $load_id[0]->maxid;

// ///ດຶງລະຫັດຫຼ້າສຸດ //////////////////

// $ip = Config::get('dbcon.ip_local');
// $port = Config::get('dbcon.port');
// $dbpp = Config::get('dbcon.ppdb');
// $dbod = Config::get('dbcon.odiendb');

// $load_id = "SELECT right(max(code), 4) as maxid FROM (
//                 select code from dblink('host= ". $ip ." port= ". $port ." user=postgres password=sml dbname= ".dbpp."',
//                                         'select code from ic_inventory') t1 (code text) where  left(t1.code, 5) = '$code_sub2'
//                 UNION ALL
//                 select code from dblink('host=10.0.40.135 port=5432 user=postgres password=sml dbname= ". obod ."',
//                                         'select code from ic_inventory') t1 (code text) where  left(t1.code, 5) = '$code_sub2'
//                 ) z";


   $code_sub2 = $request->group_sub2;

        $ip = Config::get('dbcon.ip_local');
        $port = Config::get('dbcon.port');
        $dbpp = Config::get('dbcon.ppdb');
        $dbod = Config::get('dbcon.odiendb');

        $load_id = DB::select("SELECT right(max(code), 4) as maxid FROM max_ic_code WHERE left (code, 5) ='$code_sub2'");

        $load_last_id = $load_id[0]->maxid;

///////////////////////////////

        $max_id = $load_last_id + 1;
        if ($max_id < 10) {
            $code = '000' . $max_id;
        } else if ($max_id < 100) {
            $code = '00' . $max_id;
        } else if ($max_id < 1000) {
            $code = '0' . $max_id;
        } else {
            $code = $max_id;
        }
        $code = $code_sub2 . '-'. $code;
        //$code = $request->inventory_code;
        //
        $create_code = DB::select("SELECT code_fb FROM public.crm_employee WHERE id = ?", [auth()->user()->emp_id]);
        $create_code = $create_code[0]->code_fb;
        //create pi_no
        $pi_no = DB::select("SELECT max(pi_no) FROM public.ic_inventory");
        $pi_no = $pi_no[0]->max;
        if ($pi_no == null) {
            $pi_no = 1;
        } else {
            $pi_no = $pi_no + 1;
        }

        ///ບັນທຶກ inventory
        $inventory = new Inventory();
        $inventory->ignore_sync = 0;
        $inventory->is_lock_record = 0;
        $inventory->code = $code;
        $inventory->code_old = $code;
        $inventory->name_1 = $request->name_1;
        $inventory->name_2 = $request->name_1;
        $inventory->name_eng_1 = $request->name_thai;
        $inventory->item_type = $request->item_type;
        $inventory->item_category = $request->item_category;
        $inventory->group_main = $request->group_main;
        $inventory->item_brand = $request->item_brand;
        $inventory->item_pattern = $request->item_pattern;
        $inventory->item_design = $request->item_design;
        $inventory->item_size = $request->item_size;
        $inventory->item_status = 0;
        $inventory->unit_type = $request->unit_type;
        $inventory->cost_type = $request->cost_type;
        $inventory->tax_type = 0;
        $inventory->item_sale_type = 0;
        $inventory->item_rent_type = 0;
        $inventory->unit_standard = $request->unit_standard;
        $inventory->unit_cost = $request->unit_cost;
        $inventory->ic_serial_no = 0;
        $inventory->status = 0;
        $inventory->unit_standard_name = $request->unit_standard;
        $inventory->update_price = 1;
        $inventory->update_detail = 1;
        $inventory->unit_standard_stand_value = 1;
        $inventory->unit_standard_divide_value = 1;
        $inventory->group_sub = $request->group_sub;
        $inventory->use_expire = 0;
        $inventory->drink_type = 0;
        $inventory->barcode_checker_print = 0;
        $inventory->print_order_per_unit = 0;
        $inventory->production_period = 0;
        $inventory->is_new_item = 0;
        $inventory->no_discount = 0;
        $inventory->group_sub2 = $request->group_sub2;
        $inventory->name_from_remark = 0;
        $inventory->create_code = $create_code;
        $inventory->create_date_time_now = date('Y-m-d H:i:s');
        $inventory->doc_no = $request->doc_no;
        $inventory->pi_no = $pi_no;
        $inventory->models = $request->product_models;
        $inventory->creater_id = auth()->user()->emp_id;
        $inventory->ic_branch_code = $request->ic_branch_code;
        $inventory->save();
        if ($inventory) {
            ///ບັນທຶກ inventory Detail
            $inven_detail = new InventoryDetail();
            $inven_detail->ignore_sync = 0;
            $inven_detail->is_lock_record = 0;
            $inven_detail->ic_code = $code;
            $inven_detail->po_over = 0;
            $inven_detail->so_over = 0;
            $inven_detail->start_purchase_wh = $request->start_purchase_wh;
            $inven_detail->start_purchase_shelf = $request->start_purchase_shelf;
            $inven_detail->start_purchase_unit = $request->start_purchase_unit;
            $inven_detail->start_sale_wh = $request->start_sale_wh;
            $inven_detail->start_sale_shelf = $request->start_sale_shelf;
            $inven_detail->start_sale_unit = $request->start_sale_unit;
            $inven_detail->reserve_status = 0;
            $inven_detail->purchase_point = 0;
            $inven_detail->user_status = 0;
            $inven_detail->accrued_control = 0;
            $inven_detail->lock_price = 0;
            $inven_detail->lock_discount = 0;
            $inven_detail->lock_cost = 0;
            $inven_detail->is_end = 0;
            $inven_detail->is_hold_purchase = 0;
            $inven_detail->is_hold_sale = 0;
            $inven_detail->is_stop = 0;
            $inven_detail->balance_control = 0;
            $inven_detail->pi_no = $pi_no;
            $inven_detail->save();
            //ບັນທຶກ inventory unit
            foreach ($request->unit_code as $key => $unit_code) {
                $inven_unit = new InventoryUnit();
                $inven_unit->code = $unit_code;
                $inven_unit->line_number = $key;
                $inven_unit->stand_value = $request->stand_value[$key];
                $inven_unit->divide_value = $request->divide_value[$key];
                $inven_unit->ratio = $request->ratio[$key];
                $inven_unit->row_order = $request->row_order[$key];
                $inven_unit->ic_code = $code;
                $inven_unit->status = 1;
                $inven_unit->create_date_time_now = date("Y-m-d H:i:s");
                $inven_unit->pi_no = $pi_no;
                $inven_unit->save();
            }
        }
        return response()->json('success');
    }

    public function load_data(Request $request)
    {
        $base = $request->session()->get('choose-base');
        if ($base == 'pp') {
            $db = Config::get('dbcon.ppdb');
        } else {
            $db = Config::get('dbcon.odiendb');
        }
        $purchasing = PurchasingInventory::join('crm_employee', 'crm_employee.id', 'ic_purchasing_inventory.creater')
            ->where('ic_purchasing_inventory.ch_status', 0)
            ->where('ic_purchasing_inventory.base', $base)
            ->select('ic_purchasing_inventory.doc_no', 'ic_purchasing_inventory.creater', 'crm_employee.emp_name', 'crm_employee.code_fb')
            ->get();
            $product_data = array();
            //$ip = Config::get('dbcon.ip_local');

            $ip = Config::get('dbcon.ip_local');
            $port = Config::get('dbcon.port');
            foreach ($purchasing as $key => $value) {
                $product = DB::select("SELECT t1.doc_no, t1.code, t1.name_1, t1.name_eng_1, t1.unit_standard, t2.name_1 AS ph1, t3.name_1 AS ph2, t4.name_1 AS ph3, t5.name_1 AS ph4, t6.name_1 AS ph5 , t7.name_1 AS ph6, t8.name_1 AS ph7, t9.name_1 AS ph8 FROM ic_inventory AS t1,
                (SELECT * FROM dblink('host = ".$ip." user = postgres port = ".$port." password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group') AS t1(code text, name_1  text) ) AS t2,
                (SELECT * FROM dblink('host = ".$ip." user = postgres port = ".$port." password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub') AS t1(code text, name_1  text) ) AS t3,
                (SELECT * FROM dblink('host = ".$ip." user = postgres port = ".$port." password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub2') AS t1(code text, name_1  text) ) AS t4,
                (SELECT * FROM dblink('host = ".$ip." user = postgres port = ".$port." password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_category') AS t1(code text, name_1  text) ) AS t5,
                (SELECT * FROM dblink('host = ".$ip." user = postgres port = ".$port." password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_brand') AS t1(code text, name_1  text) ) AS t6,
                (SELECT * FROM dblink('host = ".$ip." user = postgres port = ".$port." password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_pattern') AS t1(code text, name_1  text) ) AS t7,
                (SELECT * FROM dblink('host = ".$ip." user = postgres port = ".$port." password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_size') AS t1(code text, name_1  text) ) AS t8,
                (SELECT * FROM dblink('host = ".$ip." user = postgres port = ".$port." password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_design') AS t1(code text, name_1  text) ) AS t9
                WHERE t1.group_main = t2.code AND t1.group_sub = t3.code AND t1.group_sub2 = t4.code AND t1.item_category = t5.code AND
                t1.item_brand = t6.code AND t1.item_pattern = t7.code AND t1.item_size = t8.code AND t1.item_design = t9.code AND t1.doc_no = ? ORDER BY code ASC", [$value->doc_no]);
                $product_data[] = $product;
            }
        return response()->json(['purchasing'=>$purchasing,'product_data'=>$product_data]);
    }

    public function load_wh_self(Request $request)
    {
        $wh_code = $request->wh_code;
        $base = $request->session()->get('choose-base');
        if ($base == 'pp') {
            $self = DB::connection('pgsql_pp')->select('SELECT * FROM public.ic_shelf WHERE whcode = ?', [$wh_code]);
        } else {
            $self = DB::connection('pgsql_od')->select('SELECT * FROM public.ic_shelf WHERE whcode = ?', [$wh_code]);
        }
        return response()->json($self);
    }

    public function delete_purchasing_inventory(Request $request){
        $doc_no = $request->doc_no;
        $code = $request->inven_code;
        $delete = DB::delete("DELETE FROM public.ic_inventory WHERE doc_no = ? AND code = ?", [$doc_no, $code]);
        if ($delete) {
            echo 'success';
        } else {

        }
    }

    public function show_purchasing_inventory(Request $request)
    {
        $doc_no = $request->doc_no;
        $code = $request->code;
        $base = $request->session()->get('choose-base');
        if ($base == 'pp') {
            $db = Config::get('dbcon.ppdb');
        } else {
            $db = Config::get('dbcon.odiendb');
        }
        $ip = Config::get('dbcon.ip_local');
        $product = DB::select("SELECT t1.doc_no, t1.code, t1.name_1, t1.unit_standard, t1.item_type, t1.unit_type, t1.unit_cost, t2.name_1 AS ph1, t3.name_1 AS ph2, t4.name_1 AS ph3, t5.name_1 AS ph4, t6.name_1 AS ph5 , t7.name_1 AS ph6, t8.name_1 AS ph7, t9.name_1 AS ph8, t10.start_purchase_wh , t10.start_purchase_shelf, t10.start_sale_wh, t10.start_sale_shelf, t10.start_purchase_unit, t10.start_sale_unit, t1.pi_no
        FROM ic_inventory AS t1,
                (SELECT * FROM dblink('host = ". $ip . " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group') AS t1(code text, name_1  text) ) AS t2,
                (SELECT * FROM dblink('host = ". $ip . " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub') AS t1(code text, name_1  text) ) AS t3,
                (SELECT * FROM dblink('host = ". $ip . " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_group_sub2') AS t1(code text, name_1  text) ) AS t4,
                (SELECT * FROM dblink('host = ". $ip . " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_category') AS t1(code text, name_1  text) ) AS t5,
                (SELECT * FROM dblink('host = ". $ip . " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_brand') AS t1(code text, name_1  text) ) AS t6,
                (SELECT * FROM dblink('host = ". $ip . " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_pattern') AS t1(code text, name_1  text) ) AS t7,
                (SELECT * FROM dblink('host = ". $ip . " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_size') AS t1(code text, name_1  text) ) AS t8,
                (SELECT * FROM dblink('host = ". $ip . " user = postgres password = sml dbname= ". $db ."', 'SELECT code, name_1 FROM ic_design') AS t1(code text, name_1  text) ) AS t9, ic_inventory_detail AS t10
                WHERE t1.group_main = t2.code AND t1.group_sub = t3.code AND t1.group_sub2 = t4.code AND t1.item_category = t5.code AND
                t1.item_brand = t6.code AND t1.item_pattern = t7.code AND t1.item_size = t8.code AND t1.item_design = t9.code AND t1.pi_no = t10.pi_no
                AND t1.doc_no = ? AND t1.code = ? ORDER BY code ASC",[$doc_no, $code]);
        if (count($product) > 0) {
            $unit_use = InventoryUnit::where('pi_no', $product[0]->pi_no)->get();
            return view('purchasing.show_purchasing', compact('product', 'unit_use'));
        } else {
            return redirect('/');
        }
    }

    public function edit_purchasing_inventory(Request $request)
    {
        $doc_no = $request->doc_no;
        $code = $request->code;
        $product = DB::select("SELECT t1.*, t10.start_purchase_wh , t10.start_purchase_shelf, t10.start_sale_wh, t10.start_sale_shelf, t10.start_purchase_unit, t10.start_sale_unit
        FROM ic_inventory AS t1, ic_inventory_detail AS t10
        WHERE t1.pi_no = t10.pi_no AND t1.doc_no = ? AND t1.code = ? ORDER BY code ASC",[$doc_no, $code]);
        if (count($product) > 0) {
            $base = $request->session()->get('choose-base');

            if ($base == 'pp') {
                $db = Config::get('dbcon.ppdb');
                $ic_unit = DB::connection('pgsql_pp')->select('SELECT * FROM ic_unit');
                $ic_group = DB::connection('pgsql_pp')->select('SELECT * FROM ic_group');
                $ic_category = DB::connection('pgsql_pp')->select('SELECT * FROM ic_category');
                $ic_warehouse = DB::connection('pgsql_pp')->select('SELECT * FROM ic_warehouse');
                $group_sub1 = DB::connection('pgsql_pp')->select('SELECT * FROM public.ic_group_sub WHERE main_group = ?', [$product[0]->group_main]);
                $group_sub2 = DB::connection('pgsql_pp')->select('SELECT * FROM public.ic_group_sub2 WHERE main_group = ? AND ic_group_sub_code = ?', [$product[0]->group_main, $product[0]->group_sub]);
                //
                $brand = DB::connection('pgsql_pp')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_brand t1, join_cate_brand t2
                WHERE t1.code = t2.brand_code AND t2.category_code = ?', [$product[0]->item_category]);
                //
                $pattern = DB::connection('pgsql_pp')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_pattern t1, join_cate_pattern t2
                WHERE t1.code = t2.pattern_code AND t2.category_code = ?', [$product[0]->item_category]);
                //
                $size = DB::connection('pgsql_pp')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_size t1, join_cate_size t2
                WHERE t1.code = t2.size_code AND t2.category_code = ?', [$product[0]->item_category]);
                //
                $design = DB::connection('pgsql_pp')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_design t1, join_cate_design t2
                    WHERE t1.code = t2.design_code AND t2.category_code = ?', [$product[0]->item_category]);
                //
                $product_data = DB::connection('pgsql_pp')->select('SELECT * FROM public.join_products
                    WHERE category_code = ?', [$product[0]->item_category]);

                $start_purchase_shelf = DB::connection('pgsql_pp')->select('SELECT * FROM public.ic_shelf WHERE whcode = ?', [$product[0]->start_purchase_wh]);
                $start_sale_shelf = DB::connection('pgsql_pp')->select('SELECT * FROM public.ic_shelf WHERE whcode = ?', [$product[0]->start_sale_wh]);
            } else {
                $db = Config::get('dbcon.odiendb');
                $ic_unit = DB::connection('pgsql_od')->select('SELECT * FROM ic_unit');
                $ic_group = DB::connection('pgsql_od')->select('SELECT * FROM ic_group');
                $ic_category = DB::connection('pgsql_od')->select('SELECT * FROM ic_category');
                $ic_warehouse = DB::connection('pgsql_od')->select('SELECT * FROM ic_warehouse');
                $group_sub1 = DB::connection('pgsql_od')->select('SELECT * FROM public.ic_group_sub WHERE main_group = ?', [$product[0]->group_main]);
                $group_sub2 = DB::connection('pgsql_od')->select('SELECT * FROM public.ic_group_sub2 WHERE main_group = ? AND ic_group_sub_code = ?', [$product[0]->group_main, $product[0]->group_sub]);
                //
                $brand = DB::connection('pgsql_od')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_brand t1, join_cate_brand t2
                WHERE t1.code = t2.brand_code AND t2.category_code = ?', [$product[0]->item_category]);
                //
                $pattern = DB::connection('pgsql_od')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_pattern t1, join_cate_pattern t2
                WHERE t1.code = t2.pattern_code AND t2.category_code = ?', [$product[0]->item_category]);
                //
                $size = DB::connection('pgsql_od')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_size t1, join_cate_size t2
                WHERE t1.code = t2.size_code AND t2.category_code = ?', [$product[0]->item_category]);
                //
                $design = DB::connection('pgsql_od')->select('SELECT t1.code, t1.name_1, t2.category_code FROM ic_design t1, join_cate_design t2
                WHERE t1.code = t2.design_code AND t2.category_code = ?', [$product[0]->item_category]);
                //
                $product_data = DB::connection('pgsql_od')->select('SELECT * FROM public.join_products
                    WHERE category_code = ?', [$product[0]->item_category]);

                $start_purchase_shelf = DB::connection('pgsql_od')->select('SELECT * FROM public.ic_shelf WHERE whcode = ?', [$product[0]->start_purchase_wh]);
                $start_sale_shelf = DB::connection('pgsql_od')->select('SELECT * FROM public.ic_shelf WHERE whcode = ?', [$product[0]->start_sale_wh]);
            }
            $unit_use = InventoryUnit::where('pi_no', $product[0]->pi_no)->get();
            return view('purchasing.edit-purchasing', compact('product', 'unit_use', 'ic_unit', 'ic_group', 'ic_category', 'ic_warehouse', 'group_sub1', 'group_sub2', 'brand', 'pattern', 'size', 'design', 'start_purchase_shelf', 'start_sale_shelf', 'product_data'));
        } else {
            return redirect('/');
        }
    }

    public function edit_pur_product(Request $request)
    {
        //gen code
        $code = $request->code;
        //ດຶງລະຫັດຜູ້ສ້າງ
        $create_code = DB::select("SELECT code_fb FROM public.crm_employee WHERE id = ?", [auth()->user()->emp_id]);
        $create_code = $create_code[0]->code_fb;
        //create pi_no
        $pi_no = $request->pi_no;
        ///ບັນທຶກ inventory
        $inventory = Inventory::find($pi_no);
        $inventory->ignore_sync = 0;
        $inventory->is_lock_record = 0;
        $inventory->code = $code;
        $inventory->code_old = $code;
        $inventory->name_1 = $request->name_1;
        $inventory->name_2 = $request->name_1;
		$inventory->name_eng_1 = $request->name_thai;
        $inventory->item_type = $request->item_type;
        $inventory->item_category = $request->item_category;
        $inventory->group_main = $request->group_main;
        $inventory->item_brand = $request->item_brand;
        $inventory->item_pattern = $request->item_pattern;
        $inventory->item_design = $request->item_design;
        $inventory->item_size = $request->item_size;
        $inventory->item_status = 0;
        $inventory->unit_type = $request->unit_type;
        $inventory->cost_type = $request->cost_type;
        $inventory->tax_type = 0;
        $inventory->item_sale_type = 0;
        $inventory->item_rent_type = 0;
        $inventory->unit_standard = $request->unit_standard;
        $inventory->unit_cost = $request->unit_cost;
        $inventory->ic_serial_no = 0;
        $inventory->status = 0;
        $inventory->unit_standard_name = $request->unit_standard;
        $inventory->update_price = 1;
        $inventory->update_detail = 1;
        $inventory->unit_standard_stand_value = 1;
        $inventory->unit_standard_divide_value = 1;
        $inventory->group_sub = $request->group_sub;
        $inventory->use_expire = 0;
        $inventory->drink_type = 0;
        $inventory->barcode_checker_print = 0;
        $inventory->print_order_per_unit = 0;
        $inventory->production_period = 0;
        $inventory->is_new_item = 0;
        $inventory->no_discount = 0;
        $inventory->group_sub2 = $request->group_sub2;
        $inventory->name_from_remark = 0;
        $inventory->create_code = $create_code;
        $inventory->create_date_time_now = date('Y-m-d H:i:s');
        $inventory->doc_no = $request->doc_no;
        $inventory->pi_no = $pi_no;
        $inventory->models = $request->product_models;
        $inventory->save();
        if ($inventory) {
            ///ບັນທຶກ inventory Detail
            $inven_detail = InventoryDetail::find($pi_no);
            $inven_detail->ignore_sync = 0;
            $inven_detail->is_lock_record = 0;
            $inven_detail->ic_code = $code;
            $inven_detail->po_over = 0;
            $inven_detail->so_over = 0;
            $inven_detail->start_purchase_wh = $request->start_purchase_wh;
            $inven_detail->start_purchase_shelf = $request->start_purchase_shelf;
            $inven_detail->start_purchase_unit = $request->start_purchase_unit;
            $inven_detail->start_sale_wh = $request->start_sale_wh;
            $inven_detail->start_sale_shelf = $request->start_sale_shelf;
            $inven_detail->start_sale_unit = $request->start_sale_unit;
            $inven_detail->reserve_status = 0;
            $inven_detail->purchase_point = 0;
            $inven_detail->user_status = 0;
            $inven_detail->accrued_control = 0;
            $inven_detail->lock_price = 0;
            $inven_detail->lock_discount = 0;
            $inven_detail->lock_cost = 0;
            $inven_detail->is_end = 0;
            $inven_detail->is_hold_purchase = 0;
            $inven_detail->is_hold_sale = 0;
            $inven_detail->is_stop = 0;
            $inven_detail->balance_control = 0;
            $inven_detail->pi_no = $pi_no;
            $inven_detail->save();
            //ລຶບໂຕເກົ່າ ແລະ ບັນທຶກໂຕໃໝ່ເຂົ້າ inventory unit
            DB::delete('DELETE FROM public.ic_unit_use WHERE pi_no = ?', [$pi_no]);
            ///
            foreach ($request->unit_code as $key => $unit_code) {
                $inven_unit = new InventoryUnit();
                $inven_unit->code = $unit_code;
                $inven_unit->line_number = $key;
                $inven_unit->stand_value = $request->stand_value[$key];
                $inven_unit->divide_value = $request->divide_value[$key];
                $inven_unit->ratio = $request->ratio[$key];
                $inven_unit->row_order = $request->row_order[$key];
                $inven_unit->ic_code = $code;
                $inven_unit->status = 1;
                $inven_unit->create_date_time_now = date("Y-m-d H:i:s");
                $inven_unit->pi_no = $pi_no;
                $inven_unit->save();
            }
        }
        return response()->json('success');
    }

    public function confirm_for_check_purchasing(Request $request)
    {
        $doc_no = $request->doc_no;
        $ch_date = date('Y-m-d H:i:s');
        $check_purchasing = DB::update("UPDATE public.ic_purchasing_inventory SET ch_date=?, ch_status=2, approver = ? WHERE doc_no=?", [$ch_date, auth()->user()->emp_id, $doc_no]);
        $item = DB::select("select count(code) from ic_inventory where doc_no='$doc_no'");

        if ($check_purchasing) {
                line::send('@dot ສົ່ງຜູກເລກບັນຊີ :'. $doc_no);
            return 'success';

        }
    }
}

?>
