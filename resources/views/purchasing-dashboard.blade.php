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
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="p-3 lao-font">
                        <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ເພີ່ມລາຍການສິນຄ້າໃໝ່
                            <button class="btn btn-sm btn-info" onclick="save_purchasing()"><i class="fa fa-plus"
                                    aria-hidden="true"></i>
                                ສ້າງການເພີ່ມສິນຄ້າໃໝ່ເຂົ້າລະບົບ</button>

                        </h4>
                        <hr>
                        <div id="show"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- The Modal -->
    <div class="modal" id="modal-add-pur-product">
        <div class="modal-dialog modal-xl">
            <div class="modal-content lao-font">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">ເພີ່ມສິນຄ້າການຈັດຊື້</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="tab">
                        <button class="tablinks active" onclick="choose_tab(event, 'item')"><i class="fa fa-list-ul"
                                aria-hidden="true"></i> ລາຍການ</button>
                        <button class="tablinks" onclick="choose_tab(event, 'unit')"><i class="fa fa-underline"
                                aria-hidden="true"></i> ຫົວໜ່ວຍ</button>
                        <button class="tablinks" onclick="choose_tab(event, 'detail')"><i class="fa fa-info"
                                aria-hidden="true"></i> ລາຍລະອຽດ</button>
                    </div>
                    <form action="{{ route('save-purchasing-product') }}" id="form-add-product" method="POST">
                        @csrf
                        <input type="hidden" name="doc_no">
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
                                            <option value="{{ $item->code }}">{{ $item->name_1 }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label for="ph2"><span class="text-danger" style="font-size: 18px">*</span>
                                        ໝວດສິນຄ້າຍ່ອຍ1 (PH2)</label>
                                    <select name="group_sub" id="ph2" class="form-control"
                                        onchange="load_group_sub2(this.value)" required>

                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="ph3"><span class="text-danger" style="font-size: 18px">*</span>
                                        ໝວດສິນຄ້າຍ່ອຍ2 (PH3)</label>
                                    <select name="group_sub2" id="ph3" class="form-control" required
                                        onchange="load_invent_code(this.value)"></select>
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
                                        {{-- <option value="">...</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->code }}">{{ $item->name_1 }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="product" class="text-warning"><span class="text-danger"
                                            style="font-size: 18px">*</span> ຊື່ສິນຄ້າ</label>
                                    <select name="item_product" id="product" class="form-control"
                                        onchange="create_product_name()" required>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="ph5" class="text-warning"><span class="text-danger"
                                            style="font-size: 18px">*</span> ຍີ່ຫໍ້ (PH5)</label>
                                    <select name="item_brand" id="ph5" class="form-control"
                                        onchange="create_product_name()" required>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="ph6"><span class="text-danger" style="font-size: 18px">*</span>
                                        ຮູບແບບ (PH6)</label>
                                    <select name="item_pattern" id="ph6" class="form-control" required>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="ph7" class="text-warning"><span class="text-danger"
                                            style="font-size: 18px">*</span> ຂະໜາດ (PH7)</label>
                                    <select name="item_size" id="ph7" class="form-control"
                                        onchange="create_product_name()" required>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label for="ph8" class="text-warning"><span class="text-danger"
                                            style="font-size: 18px">*</span> ອອກແບບ (PH8)</label>
                                    <select name="item_design" id="ph8" class="form-control"
                                        onchange="create_product_name()" required>
                                    </select>

                                </div>

                            </div>
                            <hr>
                            <div class="row">
                            <div class="col-sm-4">
                                    <label for="ic_branch_code" class="text-warning"><span class="text-danger"
                                            style="font-size: 18px">*</span> ສັ່ງຈາກສາຂາ: </label>
                                            <select name="ic_branch_code" id="ic_branch_code" class="form-control" required>
                                        <option value="00">ສຳນັກງານໃຫຍ່</option>
                                        <option value="05">ໂອດ້ຽນໄທ</option>
                                    </select>

                                </div>
                            </div>
                            <div class="row">


                                <div class="col-sm-4">
                                    <label for="item_type"><span class="text-danger" style="font-size: 18px">*</span>
                                        ກຸ່ມສິນຄ້າ</label>
                                    <select name="item_type" id="item_type" class="form-control" required>
                                        <option value="0">ສິນຄ້າທົ່ວໄປ</option>
                                        <option value="1">ສິນຄ້າບໍລິການ (ບໍ່ຄຳນວນສະຕ໋ອກ)</option>
                                        <option value="2">ສິນຄ້າໃຫ້ເຊົ່າ</option>
                                        <option value="3">ສິນຄ້າຊຸດ (ບໍ່ຄຳນວນສະຕ໋ອກ)</option>
                                        <option value="4">ສິນຄ້າຝາກຂາຍ</option>
                                        <option value="5">ສູດການຜະລິດ</option>
                                        <option value="6">ສີປະສົມ</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="unit_type"><span class="text-danger" style="font-size: 18px">*</span>
                                        ປະເພດໜ່ວຍນັບ</label>
                                    <select name="unit_type" id="unit_type" class="form-control" required>
                                        <option value="0">ໜ່ວຍນັບດຽວ</option>
                                        <option value="1">ຫຼາຍໜ່ວຍນັບ</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="cost_type"><span class="text-danger" style="font-size: 18px">*</span>
                                        ປະເພດຕົ້ນທຶນ</label>
                                    <select name="cost_type" id="cost_type" class="form-control" required>
                                        <option value="0">ຕົ້ນທຶນສະເລ່ຍ</option>
                                        <option value="1">ຕົ້ນທຶນ LOT FIFO</option>
                                        <option value="2">ຕົ້ນທຶນ LOT ກຳນົດເອງ</option>
                                        <option value="3">ຕົ້ນທຶນ FIFO ວັນໝົດອາຍຸ</option>
                                        <option value="4">ຕົ້ນທຶນມາດຕະຖານ</option>
                                        <option value="5">ຕົ້ນທຶນແບບພິເສດ</option>
                                    </select>
                                </div>


                            </div><br>
                            <div class="row">
                                <div class="col-sm-6">

                                    <input type="text" name="inventory_code" class="form-control" id="inventory_code"
                                        readonly>
                                    <label for="ph7" class="text-danger"><span class="text-danger"
                                            style="font-size: 18px">*</span> ຊື່ສິນຄ້າໃນລະບົບ (ພາສາລາວ)</label>
                                    <input type="text" name="name_1" id="product-name" class="form-control" required
                                        placeholder="">
                                    <label for="ph7" class="text-danger"><span class="text-danger"
                                            style="font-size: 18px">*</span> ຊື່ສິນຄ້າໃນລະບົບ (ພາສາໄທ)</label>
                                    <input type="text" name="name_thai" class="form-control" required placeholder="">
                                </div>
                                @php
                                    $unit = $ic_unit;
                                @endphp
                                <div class="col-sm-3">
                                    <label for="unit_cost" class="text-warning"><span class="text-danger"
                                            style="font-size: 18px">*</span>
                                        Models</label>
                                    <input type="text" class="form-control" id="product-model"
                                        onkeyup="create_product_name()" required name="product_models"
                                        style="text-transform:uppercase">
                                </div>
                                <div class="col-sm-3">
                                    <label for="unit_cost"><span class="text-danger" style="font-size: 18px">*</span>
                                        ຫົວໜ່ວຍຕົ້ນທຶນ</label>
                                    <select name="unit_cost" id="unit_cost" class="form-control" required
                                        onchange="set_unit(this.value)">
                                        <option value="">...</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->code }}">{{ $item->name_1 }}</option>
                                        @endforeach
                                    </select>
                                    <label for="unit_standard"><span class="text-danger"
                                            style="font-size: 18px">*</span>
                                        ຫົວໜ່ວຍຍອດຄົງເຫຼືອ</label>
                                    <input type="text" class="form-control" name="unit_standard" id="unit_standard"
                                        required readonly>
                                    {{-- <select name="unit_standard" id="unit_standard" class="form-control" required
                                        onchange="set_unit(this.value)">
                                        <option value="">...</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->code }}">{{ $item->name_1 }}</option>
                                        @endforeach
                                    </select> --}}
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
                                            <option value="{{ $item->code }}">[{{ $item->code }}]
                                                {{ $item->name_1 }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-5">
                                    <label for="start_purchase_shelf"><span class="text-danger"
                                            style="font-size: 18px">*</span> ບ່ອນເກັບສາງສັ່ງຊື້ເລີ້ມຕົ້ນ</label>
                                    <select name="start_purchase_shelf" id="start_purchase_shelf" class="form-control"
                                        required>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="start_purchase_unit"><span class="text-danger"
                                            style="font-size: 18px">*</span> ຫົວໜ່ວຍສັ່ງຊື້ເລີ້ມຕົ້ນ</label>
                                    <input type="text" class="form-control" id="start_purchase_unit"
                                        name="start_purchase_unit" required readonly>
                                    {{-- <select name="start_purchase_unit" id="start_purchase_unit" class="form-control"
                                        required>
                                        <option value="">...</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->code }}">{{ $item->name_1 }}</option>
                                        @endforeach
                                    </select> --}}
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
                                            <option value="{{ $item->code }}">[{{ $item->code }}]
                                                {{ $item->name_1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <label for="start_sale_shelf"><span class="text-danger"
                                            style="font-size: 18px">*</span> ບ່ອນເກັບສາງຂາຍເລີ້ມຕົ້ນ</label>
                                    <select name="start_sale_shelf" id="start_sale_shelf" class="form-control"
                                        required>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label for="start_sale_unit"><span class="text-danger"
                                            style="font-size: 18px">*</span> ຫົວໜ່ວຍຂາຍເລີ້ມຕົ້ນ</label>
                                    <input type="text" class="form-control" id="start_sale_unit"
                                        name="start_sale_unit" required readonly>
                                    {{-- <select name="start_sale_unit" id="start_sale_unit" class="form-control"
                                        required>
                                        <option value="">...</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->code }}">{{ $item->name_1 }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>

                            </div>

                        </div><br>
                        <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                            ບັນທຶກ</button>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        id="btn-close-pur-product">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="modal-choose-unit">
        <div class="modal-dialog">
            <div class="modal-content lao-font">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">ເລືອກຫົວໜ່ວຍ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <table class="table">
                        <tr>
                            <th>ເລືອກ</th>
                            <th>ລະຫັດ</th>
                            <th>ຊື່ຫົວໜ່ວຍ</th>
                        </tr>
                        <tbody>
                            @php
                                $unit = $ic_unit;
                            @endphp
                            @foreach ($unit as $item)
                                <tr>
                                    <td><button class="btn-sm btn-success btn">ເລືອກ</button></td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name_1 }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const unit = <?php echo json_encode($unit); ?>;
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#form-add-product").submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '<span class="lao-font">ຢືນຢັນ</span> ?',
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
                        url: "{{ route('save-purchasing-product') }}",
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(e) {
                            console.log(e);
                            $.unblockUI();
                            if (e == 'exit') {
                                Swal.fire({
                                    icon: 'error',
                                    title: '<span class="lao-font">ແຈ້ງເຕືອນ</span>',
                                    html: '<span class="lao-font">ຂໍ້ມູນສິນຄ້າຊ້ຳກັນ</span>'
                                })
                            } else {
                                $("#ph1").prop("selectedIndex", 0);
                                $("#ph2").prop("selectedIndex", 0);
                                $("#ph3").prop("selectedIndex", 0);
                                $("#ph4").prop("selectedIndex", 0);
                                $("#item_type").prop("selectedIndex", 0);
                                $("#unit_type").prop("selectedIndex", 0);
                                $("#cost_type").prop("selectedIndex", 0);
                                $("#unit_cost").prop("selectedIndex", 0);
                                $("#unit_standard").prop("selectedIndex", 0);
                                $("#start_purchase_wh").prop("selectedIndex", 0);
                                $("#start_sale_wh").prop("selectedIndex", 0);
                                $("#start_purchase_unit").prop("selectedIndex", 0);
                                $("#start_sale_unit").prop("selectedIndex", 0);

                                $("#start_purchase_shelf").html('');
                                $("#start_sale_shelf").html('');
                                $("#ph5").html('');
                                $("#ph6").html('');
                                $("#ph7").html('');
                                $("#ph8").html('');
                                $("#product-name").val('');
                                $("#inventory_code").val('');
                                $("#product-model").val('');
                                $("#unit-table").html('');
                                load_data();
                            }

                        }
                    });
                }
            });
        });
    });

    function load_invent_code(sub2) {
        $.ajax({
            url: "{{ route('load-invent-code') }}",
            type: 'POST',
            data: {
                'sub2': sub2
            },
            success: function(e) {
                $.unblockUI();
                let invent_code = e.inventory_code;
                let product_category = e.product_category;
                $("#inventory_code").val(invent_code);
                //
                $("#ph4").html('<option value="">...</option>');
                $.each(product_category, function(index, item) {
                    $("#ph4").append(`<option value="${item.code}">${item.name_1}</option>`);
                });
            }
        });
    }

    function create_product_name() {
        let ph4 = $("#product option:selected").text();
        let ph5 = $("#ph5 option:selected").text();
        let ph7 = $("#ph7 option:selected").text();
        let ph8 = $("#ph8 option:selected").text();
        let model = $("#product-model").val();
        model = model.toUpperCase();
        $("#product-name").val(ph4 + ' ' + ph5 + ' ' + ph7 + ' ' + ph8 + ' ' + model);
    }

    function set_unit(unit) {
        let stand = 1;
        let divide = 1;
        let ratio = 1;
        let row_order = 1;
        $("#form-add-product input[name='start_sale_unit']").val(unit);
        $("#form-add-product input[name='start_purchase_unit']").val(unit);
        $("#form-add-product input[name='unit_standard']").val(unit);
        $("#unit-table").html(`<tr>
            <td><input type="text" class="form-control" name="unit_code[]" value="${unit}" readonly required></td>
            <td><input type="text" class="form-control" name="unit_name[]" value="${unit}" readonly required></td>
            <td><input type="number" class="form-control" name="stand_value[]" value="${stand}" readonly min="1" max="100" required></td>
            <td><input type="number" class="form-control" name="divide_value[]" value="${divide}" readonly min="1" max="100" required></td>
            <td><input type="number" class="form-control" name="ratio[]" value="${ratio}" readonly min="1" max="100" required></td>
            <td><input type="number" class="form-control" name="row_order[]" value="${row_order}" readonly min="1" max="100" required></td>
        </tr>`);
    }

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

                $("#ph5").html('<option value="">...</option>');
                $.each(brand, function(i, item) {
                    $("#ph5").append(
                        `<option value="${ item.code }">${ item.name_1 }</option>`
                    );
                });
                $("#ph6").html('<option value="">...</option>');
                $.each(pattern, function(i, item) {
                    $("#ph6").append(
                        `<option value="${ item.code }">${ item.name_1 }</option>`
                    );
                });
                $("#ph7").html('<option value="">...</option>');
                $.each(size, function(i, item) {
                    $("#ph7").append(
                        `<option value="${ item.code }">${ item.name_1 }</option>`
                    );
                });
                $("#ph8").html('<option value="">...</option>');
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

    load_data();

    function load_data() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-purchasing') }}",
            type: 'GET',
            success: function(e) {
                $.unblockUI();
                $('#show').html('');
                let purchasing = e.purchasing;
                let product_data = e.product_data;

                $.each(purchasing, function(index, item) {
                    let pro_detail = '';
                    $.each(product_data[index], function(key, pro_item) {
                        pro_detail += `<tr>
                            <td>${ key + 1 }</td>
                            <td class="text-danger">[${ pro_item.code }]</td>
                            <td>${ pro_item.name_1 }</td>
                            <td>${ pro_item.name_eng_1 }</td>
                            <td>${ pro_item.unit_standard }</td>
                            <td>${ pro_item.ph1 }</td>
                            <td>${ pro_item.ph2 }</td>
                            <td>${ pro_item.ph3 }</td>
                            <td>${ pro_item.ph4 }</td>
                            <td>${ pro_item.ph5 }</td>
                            <td>${ pro_item.ph6 }</td>
                            <td>${ pro_item.ph7 }</td>
                            <td>${ pro_item.ph8 }</td>
                            <td width="150">
                                <a href="{{ url('show-inventory/${ pro_item.doc_no }/${ pro_item.code }') }}" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="delete_purchasing_inventory('${ pro_item.doc_no }', '${ pro_item.code }')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                <a href="{{ url('/spec-index/${ pro_item.code }') }}" type="button" class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                        </tr>`;
                    });
                    $('#show').append(`
                            <h6>ເລກທີ່ເອກະສານ:​ <span class="text-primary">${ item.doc_no }</span> &nbsp &nbsp &nbsp
                                ເພີ່ມໂດຍ:
                                <span class="text-primary">${ item.emp_name } [${ item.code_fb }]</span>
                                &nbsp &nbsp
                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#modal-add-pur-product"
                                    onclick="set_add_product(${ item.doc_no })"><i class="fa fa-plus-circle"
                                        aria-hidden="true"></i>
                                    ເພີ່ມລາຍການສິນຄ້າ</button>
                                    &nbsp &nbsp
                                <button class="btn btn-danger btn-sm" onclick="confirm_for_check_product(${ item.doc_no })"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    ສົ່ງໃຫ້ບັນຊີ</button>

                            </h6>
                            <table class="table">
                                <tr>
                                    <th width="50">ລຳດັບ</th>
                                    <th></th>
                                    <th>ຊື່ສິນຄ້າ (ພາສາລາວ)</th>
                                    <th>ຊື່ສິນຄ້າ (ພາສາໄທ)</th>
                                    <th>ຫົວໜ່ວຍ</th>
                                    <th>ph1</th>
                                    <th>ph2</th>
                                    <th>ph3</th>
                                    <th>ph4</th>
                                    <th>ph5</th>
                                    <th>ph6</th>
                                    <th>ph7</th>
                                    <th>ph8</th>
                                </tr>
                                <tbody id="table-add-purchasing">${pro_detail}</tbody>
                    </table>`);
                });
            }
        });
    }

    function confirm_for_check_product(doc_no) {
        Swal.fire({
            title: `<span class="lao-font">ຢືັນຢັນ</span> ?`,
            html: `<span class="lao-font text-danger">ຢືນຢັນສົ່ງລາຍການສິນຄ້າໃໝ່ ໃຫ້ຫົວໜ້າຈັດຊື້ກວດສອບ</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                $.blockUI({
                    message: ''
                });
                $.ajax({
                    url: "{{ route('confirm-for-check-purchasing') }}",
                    type: 'POST',
                    data: {
                        'doc_no': doc_no
                    },
                    success: function(e) {
                        console.log(e);
                        $.unblockUI();
                        location.reload();
                    }
                });
            }
        });
    }

    function delete_purchasing_inventory(doc_no, inven_code) {
        Swal.fire({
            title: `<span class="lao-font">ຢືນຢັນຍົກເລີກ ${inven_code}</span> ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                $.blockUI({
                    message: ''
                });
                $.ajax({
                    url: "{{ route('delete-purchasing-inventory') }}",
                    type: 'POST',
                    data: {
                        'doc_no': doc_no,
                        'inven_code': inven_code
                    },
                    success: function(e) {
                        console.log(e);
                        $.unblockUI();
                        if (e == 'success') {
                            load_data();
                        }
                    }
                })
            }
        })
    }

    function set_add_product(doc_no) {
        $("#form-add-product input[name='doc_no']").val(doc_no);
    }

    function delete_purchasing(doc_no) {
        Swal.fire({
            title: `<span class="lao-font">ຢືນຢັນຍົກເລີກ ${doc_no}</span> ?`,
            html: `<span class="lao-font text-danger">ຖ້າຍົກເລີກ ລາຍການສິນຄ້າຈະຖືກລົບອອກທັງໝົດ !!!!</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                $.blockUI({
                    message: ''
                });
                $.ajax({
                    url: "{{ route('delete-purchasing') }}",
                    type: 'POST',
                    data: {
                        'doc_no': doc_no
                    },
                    success: function(e) {
                        $.unblockUI();
                        location.reload();
                    }
                })
            }
        })
    }

    function save_purchasing() {
        Swal.fire({
            title: '<span class="lao-font">ຢືນຢັນເພີ່ມຈັດຊື້</span> ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                $.blockUI({
                    message: ''
                });
                $.ajax({
                    url: "{{ route('save-purchasing') }}",
                    type: 'POST',
                    success: function(e) {
                        $.unblockUI();
                        location.reload();
                    }
                })
            }
        })
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

    function choose_tab(evt, cityName) {
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
</script>
