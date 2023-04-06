<?php

namespace App\Imports;

use App\Models\SpecProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SpecImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SpecProduct([
            'ic_code' => $row['ic_code'],
            'name_1' => $row['name_1'],
            'unit_code' => $row['unit_code'],
            'brand' => $row['brand'],
            'model' => $row['model'],
            'size' => $row['size'],
            'color' => $row['color'],
            'weight' => $row['weight'],
            'hight' => $row['hight'],
            'width' => $row['width'],
            'lerk' => $row['lerk'],
            'inverter' => $row['inverter'],
            'acpower' => $row['acpower'],
            'remote' => $row['remote'],
            'baipad' => $row['baipad'],
            'sticker' => $row['sticker'],
            'star' => $row['star'],
            'wifi' => $row['wifi'],
            'warranry' => $row['warranry'],
            'warranry2' => $row['warranry2'],
        ]);
    }
}
