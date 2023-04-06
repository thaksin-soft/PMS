<x-app-layout>
    <style>
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
            color: white
        }

        /* Style the tab content */
        .tabcontent {
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ແກ້ໄຂ</h4>
                        <hr>

                        <div class="tab">
                            <button class="tablinks active" onclick="openCity(event, 'item')"><i class="fa fa-list-ul"
                                    aria-hidden="true"></i> ລາຍການ</button>
                            <button class="tablinks" onclick="openCity(event, 'unit')"><i class="fa fa-underline"
                                    aria-hidden="true"></i> ຫົວໜ່ວຍ</button>
                            <button class="tablinks" onclick="openCity(event, 'detail')"><i class="fa fa-info"
                                    aria-hidden="true"></i> ລາຍລະອຽດ</button>
                        </div>
                        <form action="{{ route('save-purchasing-product') }}" id="form-edit-purchase" method="POST">
                            @csrf
                            <input type="hidden" name="doc_no" value="{{ $product[0]->doc_no }}">
                            <input type="hidden" name="pi_no" value="{{ $product[0]->pi_no }}">
                            <input type="hidden" name="code" value="{{ $product[0]->code }}">
                            <div id="item" class="tabcontent" style="display: block">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="ph1"><span class="text-danger" style="font-size: 18px">*</span>
                                            ໝວດສິນຄ້າຫຼັກ (PH1)</label>
                                        @php
                                            $ph1 = $ic_group;
                                        @endphp
                                        <select name="group_main" id="ph1" class="form-control"
                                            onchange="load_group_sub(this.value)" required>
                                            <option value="">...</option>
                                            @foreach ($ph1 as $item)
                                                <option value="{{ $item->code }}" @if ($item->code == $product[0]->group_main)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="ph2"><span class="text-danger" style="font-size: 18px">*</span>
                                            ໝວດສິນຄ້າຍ່ອຍ1 (PH2)</label>
                                        <select name="group_sub" id="ph2" class="form-control"
                                            onchange="load_group_sub2(this.value)" required>
                                            <option value="">...</option>
                                            @foreach ($group_sub1 as $item)
                                                <option value="{{ $item->code }}" @if ($item->code == $product[0]->group_sub)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="ph3"><span class="text-danger" style="font-size: 18px">*</span>
                                            ໝວດສິນຄ້າຍ່ອຍ2 (PH3)</label>
                                        <select name="group_sub2" id="ph3" class="form-control" required>
                                            <option value="">...</option>
                                            @foreach ($group_sub2 as $item)
                                                <option value="{{ $item->code }}" @if ($item->code == $product[0]->group_sub2)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="ph4"><span class="text-danger" style="font-size: 18px">*</span>
                                            ປະເພດສິນຄ້າ (PH4)</label>
                                        @php
                                            $category = $ic_category;
                                        @endphp
                                        <select name="item_category" id="ph4" class="form-control" required
                                            onchange="load_brand_pattern_size_design(this.value)">
                                            <option value="">...</option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->item_category == $item->code)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="product" class="text-warning"><span class="text-danger"
                                                style="font-size: 18px">*</span> ຊື່ສິນຄ້າ</label>
                                        <select name="item_product" id="product" class="form-control"
                                            onchange="create_product_name()" required>
                                            <option value="">...</option>
                                            @foreach ($product_data as $product_item)
                                                @php
                                                    echo '<option value="' . $product_item->product_code . '">' . $product_item->product_name . '</option>';
                                                @endphp
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="ph5" class="text-warning"><span class="text-danger"
                                                style="font-size: 18px">*</span> ຍີ່ຫໍ້ (PH5)</label>
                                        <select name="item_brand" id="ph5" class="form-control"
                                            onchange="create_product_name()" required>
                                            @foreach ($brand as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->item_brand == $item->code)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="ph6"><span class="text-danger" style="font-size: 18px">*</span>
                                            ຮູບແບບ (PH6)</label>
                                        <select name="item_pattern" id="ph6" class="form-control" required>
                                            @foreach ($pattern as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->item_pattern == $item->code)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="ph7" class="text-warning"><span class="text-danger"
                                                style="font-size: 18px">*</span> ຂະໜາດ (PH7)</label>
                                        <select name="item_size" id="ph7" class="form-control"
                                            onchange="create_product_name()" required>
                                            @foreach ($size as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->item_size == $item->code)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="ph8" class="text-warning"><span class="text-danger"
                                                style="font-size: 18px">*</span> ອອກແບບ (PH8)</label>
                                        <select name="item_design" id="ph8" class="form-control"
                                            onchange="create_product_name()" required>
                                            @foreach ($design as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->item_design == $item->code)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="item_type"><span class="text-danger"
                                                style="font-size: 18px">*</span>
                                            ກຸ່ມສິນຄ້າ</label>
                                        <select name="item_type" id="item_type" class="form-control" required>
                                            <option value="0" @if ($product[0]->item_type == 0)
                                                {{ 'selected' }}
                                                @endif>ສິນຄ້າທົ່ວໄປ</option>
                                            <option value="1" @if ($product[0]->item_type == 1)
                                                {{ 'selected' }}
                                                @endif>ສິນຄ້າບໍລິການ (ບໍ່ຄຳນວນສະຕ໋ອກ)</option>
                                            <option value="2" @if ($product[0]->item_type == 2)
                                                {{ 'selected' }}
                                                @endif>ສິນຄ້າໃຫ້ເຊົ່າ</option>
                                            <option value="3" @if ($product[0]->item_type == 3)
                                                {{ 'selected' }}
                                                @endif>ສິນຄ້າຊຸດ (ບໍ່ຄຳນວນສະຕ໋ອກ)</option>
                                            <option value="4" @if ($product[0]->item_type == 4)
                                                {{ 'selected' }}
                                                @endif>ສິນຄ້າຝາກຂາຍ</option>
                                            <option value="5" @if ($product[0]->item_type == 5)
                                                {{ 'selected' }}
                                                @endif>ສູດການຜະລິດ</option>
                                            <option value="6" @if ($product[0]->item_type == 6)
                                                {{ 'selected' }}
                                                @endif>ສີປະສົມ</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="unit_type"><span class="text-danger"
                                                style="font-size: 18px">*</span>
                                            ປະເພດໜ່ວຍນັບ</label>
                                        <select name="unit_type" id="unit_type" class="form-control" required>
                                            <option value="0" @if ($product[0]->unit_type == 0)
                                                {{ 'selected' }}
                                                @endif>ໜ່ວຍນັບດຽວ</option>
                                            <option value="1" @if ($product[0]->unit_type == 1)
                                                {{ 'selected' }}
                                                @endif>ຫຼາຍໜ່ວຍນັບ</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="cost_type"><span class="text-danger"
                                                style="font-size: 18px">*</span>
                                            ປະເພດຕົ້ນທຶນ</label>
                                        <select name="cost_type" id="cost_type" class="form-control" required>
                                            <option value="0" @if ($product[0]->cost_type == 1)
                                                {{ 'selected' }}
                                                @endif>ຕົ້ນທຶນສະເລ່ຍ</option>
                                            <option value="1" @if ($product[0]->cost_type == 2)
                                                {{ 'selected' }}
                                                @endif>ຕົ້ນທຶນ LOT FIFO</option>
                                            <option value="2" @if ($product[0]->cost_type == 3)
                                                {{ 'selected' }}
                                                @endif>ຕົ້ນທຶນ LOT ກຳນົດເອງ</option>
                                            <option value="3" @if ($product[0]->cost_type == 4)
                                                {{ 'selected' }}
                                                @endif>ຕົ້ນທຶນ FIFO ວັນໝົດອາຍຸ</option>
                                            <option value="4" @if ($product[0]->cost_type == 5)
                                                {{ 'selected' }}
                                                @endif>ຕົ້ນທຶນມາດຕະຖານ</option>
                                            <option value="5" @if ($product[0]->cost_type == 6)
                                                {{ 'selected' }}
                                                @endif>ຕົ້ນທຶນແບບພິເສດ</option>
                                        </select>
                                    </div>

                                </div><br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="ph7" class="text-danger"><span class="text-danger"
                                                style="font-size: 18px">*</span> ຊື່ສິນຄ້າໃນລະບົບ(ພາສາລາວ)</label>
                                        <input type="text" name="name_1" id="product-name" class="form-control"
                                            required placeholder="...." value="{{ $product[0]->name_1 }}">
										<label for="ph7" class="text-danger"><span class="text-danger"
                                                style="font-size: 18px">*</span> ຊື່ສິນຄ້າໃນລະບົບ(ພາສາໄທ)</label>
                                        <input type="text" name="name_thai" id="product-name" class="form-control"
                                            required placeholder="...." value="{{ $product[0]->name_eng_1 }}">
                                    </div>
                                    @php
                                        $unit = $ic_unit;
                                    @endphp
                                    <div class="col-sm-3">
                                        <label for="unit_cost" class="text-warning"><span class="text-danger"
                                                style="font-size: 18px">*</span>
                                            Model</label>
                                        <input type="text" class="form-control" id="product-model"
                                            name="product_models" onkeyup="create_product_name()" required
                                            value="{{ $product[0]->models }}">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="unit_cost"><span class="text-danger"
                                                style="font-size: 18px">*</span>
                                            ຫົວໜ່ວຍຕົ້ນທຶນ</label>
                                        <select name="unit_cost" id="unit_cost" class="form-control" required
                                            onchange="set_unit(this.value)">
                                            <option value="">...</option>
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->unit_cost == $item->code)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                        <label for="unit_cost"><span class="text-danger"
                                                style="font-size: 18px">*</span>
                                            ຫົວໜ່ວຍຍອດຄົງເຫຼືອ</label>
                                        <select name="unit_standard" id="unit_standard" class="form-control" required
                                            onchange="set_unit(this.value)">
                                            <option value="">...</option>
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->unit_standard == $item->code)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div id="unit" class="tabcontent" style="display: none">
                                <button class="btn btn-sm btn-info" type="button" onclick="add_new_unit()"><i
                                        class="fa fa-plus" aria-hidden="true"></i></button>
                                <table class="table">
                                    <tr>
                                        <th>ລະຫັດ</th>
                                        <th>ຊື່</th>
                                        <th>ຕົວຕັ້ງ</th>
                                        <th>ຕົວຫານ</th>
                                        <th>ອັດຕາສ່ວນ</th>
                                        <th>ລຳດັບທີ່</th>
                                    </tr>
                                    <tbody id="unit-table">
                                        @foreach ($unit_use as $key => $item)
                                            <tr>

                                                <td><select name="unit_code[]" class="form-control"
                                                        onchange="set_unit_name({{ $key }}, this.value)">
                                                        @foreach ($unit as $unit_item)
                                                            <option value="{{ $unit_item->code }}" @if ($item->code == $unit_item->code)
                                                                {{ 'selected' }}
                                                        @endif>{{ $unit_item->name_1 }}</option>
                                        @endforeach
                                        </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="unit_name[]"
                                                id="unit_name_{{ $key }}" readonly
                                                value="{{ $item->code }}"></td>
                                        <td><input type="number" class="form-control" name="stand_value[]"
                                                onchange="caculate_ratio({{ $key }})"
                                                id="stand_value_{{ $key }}" min="1" max="100" required
                                                value="{{ $item->stand_value }}"></td>
                                        <td><input type="number" class="form-control" name="divide_value[]"
                                                onchange="caculate_ratio({{ $key }})"
                                                id="divide_value_{{ $key }}" min="1" max="100" required
                                                value="{{ $item->divide_value }}"></td>
                                        <td><input type="number" class="form-control" name="ratio[]"
                                                id="ratio_{{ $key }}" readonly min="1" max="100" required
                                                value="{{ $item->ratio }}"></td>
                                        <td><input type="number" class="form-control" name="row_order[]"
                                                id="row_order_{{ $key }}" min="1" max="100" required
                                                value="{{ $item->row_order }}"></td>
                                        <td>
                                            @if ($key > 0)
                                                <button class="btn btn-sm btn-danger" type="button"
                                                    onclick="delete_unit({{ $key }})"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            @endif
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div id="detail" class="tabcontent" style="display: none">

                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="start_purchase_wh"><span class="text-danger"
                                                style="font-size: 18px">*</span> ສາງສັ່ງຊື້ເລີ້ມຕົ້ນ</label>
                                        @php
                                            $wh = $ic_warehouse;
                                        @endphp
                                        <select name="start_purchase_wh" id="start_purchase_wh" class="form-control"
                                            required onchange="load_wh_seft1(this.value)">
                                            <option value="">...</option>
                                            @foreach ($wh as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->start_purchase_wh == $item->code)
                                                    {{ 'selected' }}
                                            @endif>[{{ $item->code }}]
                                            {{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-5">
                                        <label for="start_purchase_shelf"><span class="text-danger"
                                                style="font-size: 18px">*</span> ບ່ອນເກັບສາງສັ່ງຊື້ເລີ້ມຕົ້ນ</label>
                                        <select name="start_purchase_shelf" id="start_purchase_shelf"
                                            class="form-control" required>
                                            @foreach ($start_purchase_shelf as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->start_purchase_shelf == $item->code)
                                                    {{ 'selected' }}
                                            @endif>[{{ $item->code }}]
                                            {{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="start_purchase_unit"><span class="text-danger"
                                                style="font-size: 18px">*</span> ຫົວໜ່ວຍສັ່ງຊື້ເລີ້ມຕົ້ນ</label>
                                        <select name="start_purchase_unit" id="start_purchase_unit"
                                            class="form-control" required>
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->start_purchase_unit == $item->code)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="start_sale_wh"><span class="text-danger"
                                                style="font-size: 18px">*</span> ສາງຂາຍເລີ້ມຕົ້ນ</label>
                                        <select name="start_sale_wh" id="start_sale_wh" class="form-control" required
                                            onchange="load_wh_seft2(this.value)">
                                            <option value="">...</option>
                                            @foreach ($wh as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->start_sale_wh == $item->code)
                                                    {{ 'selected' }}
                                            @endif>[{{ $item->code }}]
                                            {{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="start_sale_shelf"><span class="text-danger"
                                                style="font-size: 18px">*</span> ບ່ອນເກັບສາງຂາຍເລີ້ມຕົ້ນ</label>
                                        <select name="start_sale_shelf" id="start_sale_shelf" class="form-control"
                                            required>
                                            @foreach ($start_sale_shelf as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->start_sale_shelf == $item->code)
                                                    {{ 'selected' }}
                                            @endif>[{{ $item->code }}]
                                            {{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="start_sale_unit"><span class="text-danger"
                                                style="font-size: 18px">*</span> ຫົວໜ່ວຍຂາຍເລີ້ມຕົ້ນ</label>
                                        <select name="start_sale_unit" id="start_sale_unit" class="form-control"
                                            required>
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->code }}" @if ($product[0]->start_sale_unit == $item->code)
                                                    {{ 'selected' }}
                                            @endif>{{ $item->code }}
                                            {{ $item->name_1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            </div><br>
                            <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                ບັນທຶກ</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function add_new_unit() {
        let qty_unit = $("#unit-table tr").length;
        let option = '<option value="">...</option>';
        unit.forEach(element => {
            option += `<option value="${element.code}">${element.name_1}</option>`;
        });
        $("#unit-table").append(`<tr> 
            <td><select name="unit_code[]" class="form-control" onchange="set_unit_name(${qty_unit}, this.value)">${option}</select></td>
            <td><input type="text" class="form-control" name="unit_name[]" id="unit_name_${qty_unit}" readonly></td>
            <td><input type="number" class="form-control" name="stand_value[]" onchange="caculate_ratio(${qty_unit})" id="stand_value_${qty_unit}" min="1" max="100" required value="1"></td>
            <td><input type="number" class="form-control" name="divide_value[]" onchange="caculate_ratio(${qty_unit})" id="divide_value_${qty_unit}" min="1" max="100" required value="1"></td>
            <td><input type="number" class="form-control" name="ratio[]" id="ratio_${qty_unit}" readonly min="1" max="100" required value="1"></td>
            <td><input type="number" class="form-control" name="row_order[]" id="row_order_${qty_unit}" min="1" max="100" required value="${qty_unit+1}"></td>
            <td><button class="btn btn-sm btn-danger" type="button" onclick="delete_unit(${qty_unit})"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
        </tr>`);
    }
    const unit = <?php echo json_encode($unit); ?>;
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#form-edit-purchase").submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '<span class="lao-font">ຢືນຢັນແກ້ໄຂຂໍ້ມູນ</span> ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#btn-close-pur-product").click();
                    $.blockUI({
                        message: ''
                    });
                    $.ajax({
                        url: "{{ route('edit-purchasing-product') }}",
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(e) {
                            console.log(e);
                            $.unblockUI();
                            window.location = '/';
                        }
                    });
                }
            });
        });
    });

    function delete_unit(index) {
        $("#unit-table tr").eq(index).remove();
    }

    function caculate_ratio(qty_unit) {
        let stand = $("#stand_value_" + qty_unit).val();
        let divide = $("#divide_value_" + qty_unit).val();
        let ratio = stand / divide;
        $("#ratio_" + qty_unit).val(ratio);
    }

    function set_unit_name(qty_unit, unit_code) {
        $("#unit_name_" + qty_unit).val(unit_code);
    }

    function load_wh_seft1(wh_code) {
        $.ajax({
            url: "{{ route('load-wh-self') }}",
            type: 'POST',
            data: {
                'wh_code': wh_code
            },
            success: function(e) {
                $("#start_purchase_shelf").html(``);
                $.unblockUI();
                $.each(e, function(index, item) {
                    $("#start_purchase_shelf").append(
                        `<option value="${item.code}">${item.name_1}</option>`);
                });
            }
        });
    }

    function load_wh_seft2(wh_code) {
        $.ajax({
            url: "{{ route('load-wh-self') }}",
            type: 'POST',
            data: {
                'wh_code': wh_code
            },
            success: function(e) {
                $("#start_sale_shelf").html(``);
                $.unblockUI();
                $.each(e, function(index, item) {
                    $("#start_sale_shelf").append(
                        `<option value="${item.code}">${item.name_1}</option>`);
                });
            }
        });
    }

    function set_unit(unit) {
        let stand = 1;
        let divide = 1;
        let ratio = 1;
        let row_order = 1;
        $("#unit-table").html(`<tr> 
            <td><input type="text" class="form-control" name="unit_code[]" value="${unit}" readonly required></td>
            <td><input type="text" class="form-control" name="unit_name[]" value="${unit}" readonly required></td>
            <td><input type="number" class="form-control" name="stand_value[]" value="${stand}" readonly min="1" max="100" required></td>
            <td><input type="number" class="form-control" name="divide_value[]" value="${divide}" readonly min="1" max="100" required></td>
            <td><input type="number" class="form-control" name="ratio[]" value="${ratio}" readonly min="1" max="100" required></td>
            <td><input type="number" class="form-control" name="row_order[]" value="${row_order}" readonly min="1" max="100" required></td>
        </tr>`);
    }

    function create_product_name() {
        let ph4 = $("#product option:selected").text();
        let ph5 = $("#ph5 option:selected").text();
        let ph7 = $("#ph7 option:selected").text();
        let ph8 = $("#ph8 option:selected").text();
        let model = $("#product-model").val();
        $("#product-name").val(ph4 + ' ' + ph5 + ' ' + ph7 + ' ' + ph8 + ' ' + model);
    }

    function load_brand_pattern_size_design(cate_code) {
        $.ajax({
            url: "{{ route('load-brand-pattern-size-design') }}",
            type: 'POST',
            data: {
                'cate_code': cate_code
            },
            success: function(e) {
                $.unblockUI();
                let brand = e.brand;
                let pattern = e.pattern;
                let size = e.size;
                let design = e.design;
                let product = e.product;

                $("#ph5").html('');
                $.each(brand, function(i, item) {
                    $("#ph5").append(
                        `<option value="${ item.code }">${ item.name_1 }</option>`
                    );
                });
                $("#ph6").html('');
                $.each(pattern, function(i, item) {
                    $("#ph6").append(
                        `<option value="${ item.code }">${ item.name_1 }</option>`
                    );
                });
                $("#ph7").html('');
                $.each(size, function(i, item) {
                    $("#ph7").append(
                        `<option value="${ item.code }">${ item.name_1 }</option>`
                    );
                });
                $("#ph8").html('');
                $.each(design, function(i, item) {
                    $("#ph8").append(
                        `<option value="${ item.code }">${ item.name_1 }</option>`
                    );
                });
                $("#product").html('<option value="">...</option>');
                $.each(product, function(i, item) {
                    $("#product").append(
                        `<option value="${ item.product_code }">${ item.product_name }</option>`
                    );
                });
                create_product_name();
            }
        })
    }

    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function load_group_sub(main_group) {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-group-sub') }}",
            type: 'GET',
            data: {
                'main_group': main_group
            },
            success: function(e) {
                $("#ph2").html(`<option value="">...</option>`);
                $.unblockUI();
                $.each(e, function(index, item) {
                    $("#ph2").append(`<option value="${item.code}">${item.name_1}</option>`);
                })

            }
        })
    }

    function load_group_sub2(group_sub) {
        $.blockUI({
            message: ''
        });
        let main_group = $("#ph1").val();
        $.ajax({
            url: "{{ route('load-group-sub2') }}",
            type: 'GET',
            data: {
                'main_group': main_group,
                'group_sub': group_sub
            },
            success: function(e) {
                $.unblockUI();
                $("#ph3").html(`<option value="">...</option>`);
                $.each(e, function(index, item) {
                    $("#ph3").append(`<option value="${item.code}">${item.name_1}</option>`);
                })

            }
        })
    }
</script>
