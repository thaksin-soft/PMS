<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecProduct extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_odmall';
    protected $table = "temp_import_attribute";
    protected $fillable = ['id','ic_code', 'name_1','unit_code',
                'brand','model','size','color','weight','hight','width','lerk',
            'inverter','acpower','remote','baipad','sticker','star','wifi','warranry','warranry2','created_at','created_at'];
}
