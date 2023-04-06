<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4><i class="fa fa-info-circle" aria-hidden="true"></i> ລາຍລະອຽດຂອງສິນຄ້າ</h4>
                        <hr>

                        <div class="row">
                            <div class="col-sm-8" style="border-right: 1px solid">
                                <h5 class="text-primary"><i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    <b>ຂໍ້ມູນສິນຄ້າ</b>
                                </h5>
                                <table>
                                    <tr>
                                        <td><b>ຊື່ສິນຄ້າ: </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->name_1 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ກຸ່ມສິນຄ້າ: </b></td>
                                        <td>
                                            @if ($product[0]->item_type == 0)
                                                <span class="text-primary">ສິນຄ້າທົ່ວໄປ</span>
                                            @elseif($product[0]->item_type == 1)
                                                <span class="text-primary">ສິນຄ້າບໍລິການ (ບໍ່ຄຳນວນສະຕ໋ອກ)</span>
                                            @elseif($product[0]->item_type == 2)
                                                <span class="text-primary">ສິນຄ້າໃຫ້ເຊົ່າ</span>
                                            @elseif($product[0]->item_type == 3)
                                                <span class="text-primary">ສິນຄ້າຊຸດ (ບໍ່ຄຳນວນສະຕ໋ອກ)</span>
                                            @elseif($product[0]->item_type == 4)
                                                <span class="text-primary">ສິນຄ້າຝາກຂາຍ</span>
                                            @elseif($product[0]->item_type == 5)
                                                <span class="text-primary">ສູດການຜະລິດ</span>
                                            @elseif($product[0]->item_type == 6)
                                                <span class="text-primary">ສີປະສົມ</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ປະເພດໜ່ວຍນັບ: </b></td>
                                        <td>
                                            @if ($product[0]->unit_type == 0)
                                                <span class="text-primary">ໜ່ວຍນັບດຽວ</span>
                                            @elseif($product[0]->unit_type == 1)
                                                <span class="text-primary">ຫຼາຍໜ່ວຍນັບ</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ປະເພດຕົ້ນທຶນ: </b></td>
                                        <td>
                                            @if ($product[0]->item_type == 0)
                                                <span class="text-primary">ຕົ້ນທຶນສະເລ່ຍ</span>
                                            @elseif($product[0]->item_type == 1)
                                                <span class="text-primary">ຕົ້ນທຶນ LOT FIFO</span>
                                            @elseif($product[0]->item_type == 2)
                                                <span class="text-primary">ຕົ້ນທຶນ LOT ກຳນົດເອງ</span>
                                            @elseif($product[0]->item_type == 3)
                                                <span class="text-primary">ຕົ້ນທຶນ FIFO ວັນໝົດອາຍຸ</span>
                                            @elseif($product[0]->item_type == 4)
                                                <span class="text-primary">ຕົ້ນທຶນມາດຕະຖານ</span>
                                            @elseif($product[0]->item_type == 5)
                                                <span class="text-primary">ຕົ້ນທຶນແບບພິເສດ</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ຫົວໜ່ວຍຕົ້ນທຶນ: </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->unit_cost }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ຫົວໜ່ວຍຍອດຄົງເຫຼືອ: </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->unit_standard }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ໝວດສິນຄ້າຫຼັກ (PH1): </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->ph1 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ໝວດສິນຄ້າຍ່ອຍ1 (PH2): </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->ph2 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ໝວດສິນຄ້າຍ່ອຍ2 (PH3): </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->ph3 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ປະເພດສິນຄ້າ (PH4): </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->ph4 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ຍີ່ຫໍ້ (PH5): </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->ph5 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ຮູບແບບ (PH6): </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->ph6 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ຂະໜາດ (PH7): </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->ph7 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ອອກແບບ (PH8): </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->ph8 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ສາງສັ່ງຊື້ເລີ້ມຕົ້ນ: </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->start_purchase_wh }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ບ່ອນເກັບສາງສັ່ງຊື້ເລີ້ມຕົ້ນ: </b></td>
                                        <td>
                                            <span
                                                class="text-primary">{{ $product[0]->start_purchase_shelf }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ຫົວໜ່ວຍສັ່ງຊື້ເລີ້ມຕົ້ນ: </b></td>
                                        <td>
                                            <span
                                                class="text-primary">{{ $product[0]->start_purchase_unit }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ສາງຂາຍເລີ້ມຕົ້ນ: </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->start_sale_wh }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ບ່ອນເກັບສາງຂາຍເລີ້ມຕົ້ນ: </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->start_sale_shelf }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>ຫົວໜ່ວຍຂາຍເລີ້ມຕົ້ນ: </b></td>
                                        <td>
                                            <span class="text-primary">{{ $product[0]->start_sale_unit }}</span>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <div class="col-sm-4">
                                <h5 class="text-primary">ຫົວໜ່ວຍ</h5>
                                <table class="table">
                                    <tr>
                                        <th>ຫົວໜ່ວຍ</th>
                                        <th>ຕົວຕັ້ງ</th>
                                        <th>ຕົວຫານ</th>
                                        <th>ອັດຕາສ່ວນ</th>
                                        <th>ລຳດັບທີ່</th>
                                    </tr>
                                    <tbody id="unit-table">
                                        @foreach ($unit_use as $unit_item)
                                            <tr>
                                                <td>{{ $unit_item->code }}</td>
                                                <td>{{ $unit_item->stand_value }}</td>
                                                <td>{{ $unit_item->divide_value }}</td>
                                                <td>{{ $unit_item->ratio }}</td>
                                                <td>{{ $unit_item->row_order }}</td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if (Auth::user()->hasRole('purchaser') or Auth::user()->hasRole('purchasinghead') or Auth::user()->hasRole('secretarypurchase') or Auth::user()->hasRole('administrator') )
                            <a href="{{ url('edit-inventory/' . $product[0]->doc_no . '/' . $product[0]->code) }}"
                                class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> ແກ້ໄຂ</a>
                                <a href="{{ url('spec-detial'.'/' . $product[0]->code) }}"
                                    class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> ໃສ່ຄຸນສົມບັດ</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
