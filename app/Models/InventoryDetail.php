<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model
{
    use HasFactory;
    protected $table = "ic_inventory_detail";
    protected $primaryKey = 'pi_no';
    protected $fillable = ['ignore_sync', 'is_lock_record', 'ic_code', 'po_over', 'so_over', 'start_purchase_wh', 'start_purchase_shelf', 'start_purchase_unit', 'start_sale_wh', 'start_sale_shelf', 'start_sale_unit', 'reserve_status', 'purchase_point', 'user_status', 'accrued_control', 'lock_price', 'lock_discount', 'lock_cost', 'is_end', 'is_hold_purchase', 'is_hold_sale', 'is_stop', 'balance_control'];
    public $incrementing = false;
    public $timestamps = false;
}