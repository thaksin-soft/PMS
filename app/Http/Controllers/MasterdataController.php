<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\ic_inventory_pp;
use App\Models\ic_inventory_od;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\paginator;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Pagination\lengthAwarePaginator;
use DataTables;

class MasterdataController extends Controller
{
    public function index(request $request)
    {
        $base = $request->session()->get('choose-base');
        if ($base == 'pp') {
                $sql_inventory = ic_inventory_pp::where('ic_inventory.manufacturer_code','!=','odien')->paginate(10);

        } else {
            $sql_inventory = ic_inventory_od::where('ic_inventory.manufacturer_code','!=','pp')->paginate(10);
        }

        return view('manage-data.uploadproductold.uploadproduct-old',compact('sql_inventory'));
    }

    public function product_list(request $request){
        $base = $request->session()->get('choose-base');
        if ($base == 'pp') {

            if($request->ajax())
                    { $output = '';
                    $query = $request->get('query');
                    if($query != '')
                        {

                            $data_sql = DB::connection('pgsql_pp')->select("select code,name_1,unit_standard,item_brand,CASE WHEN code in(select code from dblink('host=10.0.40.135 port=5432 user=postgres password=sml dbname=odm2022','select code from ic_inventory') t1 (code text)) THEN '1' ELSE '0' END as check_code FROM ic_inventory where manufacturer_code !='pp'
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

                    $data_sql = DB::connection('pgsql_od')->select("select code,name_1,unit_standard,item_brand,CASE WHEN code in(select code from dblink('host=10.0.40.135 port=5432 user=postgres password=sml dbname=pp2022','select code from ic_inventory') t1 (code text)) THEN '1' ELSE '0' END as check_code FROM ic_inventory where manufacturer_code !='odien'
                    and code like '%$query%' or name_1 like '%$query%' or item_brand like '%$query%' ");

            echo json_encode($data_sql);

            }

        }
     }
}


    public function product_upload(request $request)
    {
        $item_code = $request->item_code;

        $base = $request->session()->get('choose-base');
        if($base=='pp'){

        $inventory = DB::connection('pgsql_od')->insert("INSERT INTO ic_inventory (ignore_sync,is_lock_record,code,name_1,name_2,item_type,item_category,group_main,item_brand,item_pattern,item_design,item_size,item_status,
        unit_type,cost_type,tax_type,item_sale_type,item_rent_type,unit_standard,unit_cost,ic_serial_no,status,unit_standard_name,update_price,update_detail,
        account_code_1,account_code_2,account_code_3,account_code_4,unit_standard_stand_value,unit_standard_divide_value,group_sub,use_expire,drink_type,
        barcode_checker_print,print_order_per_unit,production_period,is_new_item,no_discount,group_sub2,name_from_remark,create_code,manufacturer_code,create_date_time_now)

        SELECT 0,0,code,name_1,name_2,0,item_category,group_main,item_brand,item_pattern,item_design,item_size,0,0,0,0,0,0,unit_standard,unit_standard,0,0,unit_standard,1,1,account_code_1,account_code_2,account_code_3,account_code_4,1,1,group_sub,
        0,0,0,0,0,0,0,group_sub2,0,'sin','pp',current_date::date FROM dblink('host=10.0.40.135 port=5432 user=postgres password=sml dbname=pp2022',
                             'SELECT code,name_1,name_2,item_category,group_main,item_brand,item_pattern,item_design,item_size,unit_standard,account_code_1,account_code_2,account_code_3,account_code_4,group_sub,group_sub2 FROM ic_inventory') AS t1
                             (code text,name_1 text,name_2 text, item_category text,group_main text,item_brand text,item_pattern text,item_design text,item_size text,unit_standard text,account_code_1 text,account_code_2 text,account_code_3 text,account_code_4 text,group_sub text,group_sub2 text)
        where code ='$item_code'");

            if($inventory){
                $inventory_detail = DB::connection('pgsql_od')->INSERT("INSERT INTO ic_inventory_detail(ignore_sync,is_lock_record,ic_code,po_over,so_over,start_purchase_wh,start_purchase_shelf,start_purchase_unit,start_sale_wh,
                start_sale_shelf,start_sale_unit,reserve_status,purchase_point,user_status,accrued_control,lock_price,lock_discount,lock_cost,
                is_end,is_hold_purchase,is_hold_sale,is_stop,balance_control)


                SELECT 0,0,ic_code,0,0,start_purchase_wh,start_purchase_shelf,start_purchase_unit,start_sale_wh,
                start_sale_shelf,start_sale_unit,0,0,0,0,0,0,0,0,0,0,0,0 FROM dblink('host = 10.0.40.135 port=5432 user=postgres password=sml dbname=pp2022',
                                          'SELECT ic_code,start_purchase_wh,start_purchase_shelf,start_purchase_unit,start_sale_wh,
                start_sale_shelf,start_sale_unit FROM ic_inventory_detail') AS t3(ic_code text,start_purchase_wh text,start_purchase_shelf text,start_purchase_unit text,start_sale_wh text,
                start_sale_shelf text,start_sale_unit text)
                WHERE ic_code = '$item_code'");


                if($inventory_detail)
                {
                    $unit_use = DB::connection('pgsql_od')->INSERT("INSERT INTO ic_unit_use(code,line_number,stand_value,divide_value,ratio,row_order,ic_code,status,unit_size)
                    SELECT code,line_number,stand_value,divide_value,ratio,row_order,ic_code,status,unit_size FROM dblink('host=10.0.40.135 port=5432 user=postgres password=sml dbname=pp2022',
                                              'SELECT code,line_number,stand_value,divide_value,ratio,row_order,ic_code,status,unit_size FROM ic_unit_use') AS t3
                                              (code text,line_number numeric,stand_value numeric,divide_value numeric,ratio numeric,row_order integer,ic_code text,status smallint,unit_size numeric)
                    where ic_code = '$item_code'");

                if($unit_use){
                    $wh = DB::connection('pgsql_od')->select("select code,whcode FROM ic_shelf");
                    foreach($wh as $key => $item){
                        $sql_use = DB::connection('pgsql_od')->INSERT("INSERT INTO ic_wh_shelf(wh_code,shelf_code,ic_code,status)values('$item->whcode','$item->code','$item_code',1)");
                    }
                    if($sql_use)
                    {
                        return 'success';
                    }
                }

                }
            }

        }else{
                $inventory = DB::connection('pgsql_pp')->insert("INSERT INTO ic_inventory (ignore_sync,is_lock_record,code,name_1,name_2,item_type,item_category,group_main,item_brand,item_pattern,item_design,item_size,item_status,
                unit_type,cost_type,tax_type,item_sale_type,item_rent_type,unit_standard,unit_cost,ic_serial_no,status,unit_standard_name,update_price,update_detail,
                account_code_1,account_code_2,account_code_3,account_code_4,unit_standard_stand_value,unit_standard_divide_value,group_sub,use_expire,drink_type,
                barcode_checker_print,print_order_per_unit,production_period,is_new_item,no_discount,group_sub2,name_from_remark,create_code,manufacturer_code,create_date_time_now)

                SELECT 0,0,code,name_1,name_2,0,item_category,group_main,item_brand,item_pattern,item_design,item_size,0,0,0,0,0,0,unit_standard,unit_standard,0,0,unit_standard,1,1,account_code_1,account_code_2,account_code_3,account_code_4,1,1,group_sub,
                0,0,0,0,0,0,0,group_sub2,0,'sin','pp',current_date::date FROM dblink('host = 10.0.40.135 port = 5432 user = postgres password = sml dbname= odm2022',
                                    'SELECT code,name_1,name_2,item_category,group_main,item_brand,item_pattern,item_design,item_size,unit_standard,account_code_1,account_code_2,account_code_3,account_code_4,group_sub,group_sub2 FROM ic_inventory') AS t1
                                    (code text,name_1 text,name_2 text, item_category text,group_main text,item_brand text,item_pattern text,item_design text,item_size text,unit_standard text,account_code_1 text,account_code_2 text,account_code_3 text,account_code_4 text,group_sub text,group_sub2 text)
                where code ='$item_code'");

                        if($inventory){
                            $inventory_detail = DB::connection('pgsql_pp')->INSERT("INSERT INTO ic_inventory_detail(ignore_sync,is_lock_record,ic_code,po_over,so_over,start_purchase_wh,start_purchase_shelf,start_purchase_unit,start_sale_wh,
                            start_sale_shelf,start_sale_unit,reserve_status,purchase_point,user_status,accrued_control,lock_price,lock_discount,lock_cost,
                            is_end,is_hold_purchase,is_hold_sale,is_stop,balance_control)


                            SELECT 0,0,ic_code,0,0,start_purchase_wh,start_purchase_shelf,start_purchase_unit,start_sale_wh,
                            start_sale_shelf,start_sale_unit,0,0,0,0,0,0,0,0,0,0,0,0 FROM dblink('host = 10.0.40.135 port = 5432 user = postgres password = sml dbname= odm2022',
                                                    'SELECT ic_code,start_purchase_wh,start_purchase_shelf,start_purchase_unit,start_sale_wh,
                            start_sale_shelf,start_sale_unit FROM ic_inventory_detail') AS t3(ic_code text,start_purchase_wh text,start_purchase_shelf text,start_purchase_unit text,start_sale_wh text,
                            start_sale_shelf text,start_sale_unit text)
                            WHERE ic_code = '$item_code'");


                                if($inventory_detail)
                                {
                                    $unit_use = DB::connection('pgsql_pp')->INSERT("INSERT INTO ic_unit_use(code,line_number,stand_value,divide_value,ratio,row_order,ic_code,status,unit_size)
                                    SELECT code,line_number,stand_value,divide_value,ratio,row_order,ic_code,status,unit_size FROM dblink('host = 10.0.40.135 port = 5432 user = postgres password = sml dbname= odm2022',
                                                            'SELECT code,line_number,stand_value,divide_value,ratio,row_order,ic_code,status,unit_size FROM ic_unit_use') AS t3
                                                            (code text,line_number numeric,stand_value numeric,divide_value numeric,ratio numeric,row_order integer,ic_code text,status smallint,unit_size numeric)
                                    where ic_code = '$item_code'");

                                        if($unit_use){
                                        $wh = DB::connection('pgsql_pp')->select("select code,whcode FROM ic_shelf");
                                            foreach($wh as $key => $item){
                                                $sql_use = DB::connection('pgsql_pp')->INSERT("INSERT INTO ic_wh_shelf(wh_code,shelf_code,ic_code,status)values('$item->whcode','$item->code','$item_code',1)");
                                            }

                                            if($sql_use)
                                            {
                                                return 'success';
                                            }

                                        }
                                }

                        }

            }
 }

    public function paginate($items, $perPage = 10, $page = null)
        {
            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
            $total = count($items);
            $currentpage = $page;
            $offset = ($currentpage * $perPage) - $perPage ;
            $itemstoshow = array_slice($items , $offset , $perPage);
            return new LengthAwarePaginator($itemstoshow ,$total ,$perPage);
        }


}
