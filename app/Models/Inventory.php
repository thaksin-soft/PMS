<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = "ic_inventory";
    protected $primaryKey = 'pi_no';
    public $incrementing = false;  
    public $timestamps = false;
    protected $fillable = ['ignore_sync', 'ignore_sync', 'roworder', 'code', 'name_1', 'name_2', 'name_eng_1', 'name_eng_2', 'name_market', 'name_for_bill', 'short_name', 'name_for_pos', 'name_for_search', 'item_type', 'item_category', 'group_main', 'item_brand', 'item_pattern', 'item_design', 'item_grade', 'item_class', 'item_size', 'item_color', 'item_character', 'item_status', 'unit_type', 'cost_type', 'tax_type', 'item_sale_type', 'item_rent_type', 'unit_standard', 'unit_cost', 'income_type', 'description', 'item_model', 'ic_serial_no', 'remark', 'status', 'guid_code', 'last_movement_date', 'average_cost', 'item_in_stock', 'balance_qty', 'accrued_in_qty', 'unit_standard_name', 'update_price', 'update_detail', 'account_code_1', 'account_code_2', 'account_code_3', 'account_code_4', 'book_out_qty', 'doc_format_code', 'unit_standard_stand_value', 'unit_standard_divide_value', 'sign_code', 'supplier_code', 'fixed_cost', 'drink_type', 'average_cost_1', 'group_sub', 'use_expire', 'barcode_checker_print', 'print_order_per_unit', 'production_period', 'is_new_item', 'commission_rate', 'is_eordershow', 'no_discount', 'serial_no_format', 'pos_no_sum', 'item_promote', 'sum_sale_1', 'is_speech', 'medicine_register_number', 'medicine_standard_code', 'quantity', 'degree', 'is_product_boonrawd', 'tpu_code', 'gpu_code', 'group_sub2', 'create_date_time_now', 'ic_discount_group', 'name_from_remark', 'manufacturer_code', 'create_datetime', 'last_update_date_time', 'create_code', 'last_update_code', 'have_take_away', 'currency_code', 'topping_product', 'product_age', 'qty_per_pallet', 'qc_product', 'qc_product_retest_day', 'doc_no', 'pi_no', 'models', 'creater_id'];
}