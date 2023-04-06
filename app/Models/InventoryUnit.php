<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryUnit extends Model
{
    use HasFactory;
    protected $table = "ic_unit_use";
    protected $primaryKey = 'ic_code, code, pi_no';
    public $incrementing = false;  
    public $timestamps = false;
    protected $fillable = ['code', 'line_number', 'stand_value', 'divide_value', 'ratio', 'row_order', 'ic_code', 'status', 'create_date_time_now', 'pi_no'];
}