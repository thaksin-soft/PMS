<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ic_category extends Model
{
    use HasFactory;
    protected $table = "ic_category";
    public $incrementing = false;  
    public $timestamps = false;
    protected $fillable = ['code','name_1'];
    
}
