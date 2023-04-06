<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ic_brand extends Model
{
    use HasFactory;
    protected $table = 'ic_brand';
    protected $fillable = ['code','name_1','name_2','create_date_time_now'];
}
