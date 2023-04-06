<?php

namespace App\Exports;

use App\Models\SpecProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SpecExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SpecProduct::select('ic_code','name_1','unit_code','brand','model','size','color','weight','hight','width','lerk','inverter','acpower','remote','baipad','sticker','wifi','warranry','warranry2')->get();
    }

    public function headings(): array
    {
        return ["ລະຫັດສິນຄ້າ", "ລາຍການ", "ຫົວໜ່ວຍ","ຍີ່ຫໍ້","ລຸ້ນ","ຂະໜາດ","ສີ","ນໍ້າໜັກ","ສູງ","ກວ້າງ","ເລີກ","ອິນເວີເຕີ","ກຳລັງໄຟຟ້າ","ລີໂມດ","ໃບພັດ","ສະຕິ້ກເກີ້ເບີ5","ໄວໄຟ","ຮັບປະກັນອາໄຫຼ່","ຮັບປະກັນອາໄຫຼ່ພິເສດ"];
    }
}
