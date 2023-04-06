<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasingInventory extends Model
{
    use HasFactory;
    protected $table = "ic_purchasing_inventory";
    protected $primaryKey = 'doc_no';
    protected $fillable = ['doc_no', 'in_date', 'ch_date', 'ch_status', 'up_status', 'creater', 'approver', 'uploader', 'base', 'up_date'];
}