<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ic_inventory_pp extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_pp';
    protected $table = 'ic_inventory';
    protected $fillable = ['code','name_1','unit_standard'];

}
