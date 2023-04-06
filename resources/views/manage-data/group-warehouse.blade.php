<x-app-layout>
    <style>
        /* Style the buttons */
        .category {
            border: none;
            outline: none;
            padding: 10px 16px;
            background-color: #f1f1f1;
            cursor: pointer;
            font-size: 16px;
            list-style-type: none;
            margin-bottom: 3px;
        }

        /* Style the active class, and buttons on mouse-over */
        .category-active {
            background-color: #666;
            color: white;
        }

        .category:hover {
            background-color: rgb(209, 209, 209);
            color: white
        }

    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="p-3 lao-font">
                        <h5><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ເພີ່ມຍີ່ຫໍ້ສິນຄ້າ</h5>
                        <hr>

                        <div class="row">
                            <div class="col-sm-4">
                                <h5 class="text-center text-primary"><b class="text-danger">*</b> ໝວດສິນຄ້າຫຼັກ (PH1)
                                </h5>
                                <div id="" style="overflow:scroll; height: 70vh;">
                                    <ul id="my-category">
                                        @foreach ($ic_group as $item)
                                            <li class="category" onclick="load_group_wh('{{ $item->code }}')">
                                                {{ $item->name_1 }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h5><i class="fa fa-home" aria-hidden="true"></i> ສາງເກັບ</h5>
                                <div id="insert-cate-group_wh">

                                </div>
                                <table class="table">
                                    <tr>
                                        <th width="50">ລຳດັບ</th>
                                        <th>ລະຫັດ</th>
                                        <th>ຊື່ສາງ</th>
                                    </tr>
                                    <tbody id="table-show-group_wh">

                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="add-cate-group_wh">
        <div class="modal-dialog">
            <div class="modal-content lao-font">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <input type="text" class="form-control" id="search-group_wh" onkeyup="search_group_wh()"
                        placeholder="ຄົ້ນຫາ...">
                    <input type="hidden" id="group_code">
                    <table id="group_wh-table" class="table">
                        <tr>
                            <th width="50">ເລືອກ</th>
                            <th>code</th>
                            <th>ຊື່ສາງ</th>
                        </tr>
                        <tbody id="ic-group_wh"></tbody>


                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        id="btn-close-modal">Close</button>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>

<script>
    function search_group_wh() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-group_wh");
        filter = input.value.toUpperCase();
        table = document.getElementById("group_wh-table");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
    // Add active class to the current button (highlight it)
    var header = document.getElementById("my-category");
    var btns = header.getElementsByClassName("category");
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("category-active");
            if (current.length > 0) {
                current[0].className = current[0].className.replace(" category-active", "");
            }
            this.className += " category-active";
        });
    }

    function load_group_wh(group_code) {
        $("#ic-group_wh").html('');
        load_warehouse(group_code);
        $("#insert-cate-group_wh").html(
            `<button class="btn btn-sm btn-info" onclick="set_add_cate_group_wh('${group_code}')" data-toggle="modal" data-target="#add-cate-group_wh"><i class="fa fa-plus" aria-hidden="true"></i> ເພີ່ມຍີ່ຫໍ້ສິນຄ້າ</button>`
        );
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-group-wh') }}",
            type: 'POST',
            data: {
                'group_code': group_code
            },
            success: function(e) {
                $.unblockUI();
                $("#table-show-group_wh").html('');
                $.each(e, function(index, item) {
                    $("#table-show-group_wh").append(`<tr>
                                            <td>${index+1}</td>
                                            <td>${item.code}</td>
                                            <td>${item.name_1}</td>
                                            <td width="50"><a href="#" data-toggle="modal" class="text-danger" onclick="delete_cate_group_wh('${item.code}', '${group_code}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                        </tr>`);
                });
            }
        })
    }

    function load_warehouse(group_code) {
        $.ajax({
            url: "{{ route('load-warehouse') }}",
            type: 'POST',
            data: {
                'group_code': group_code
            },
            success: function(e) {
                let ic_warehouse = e.ic_warehouse;
                let group_warehouse = e.group_warehouse;
                $.unblockUI();
                $("#ic-group_wh").html('');
                $.each(ic_warehouse, function(index, item) {
                    //ກວດສອບລາຍການທີ່ເພີ່ມແລ້ວ
                    let checked = '';
                    $.each(group_warehouse, function(j, ch_item) {
                        if (item.code == ch_item.warehouse_code) {
                            checked = "checked";
                            return false;
                        }
                    });
                    ///////////////////

                    $("#ic-group_wh").append(`<tr>
                                <td>
                                    <label class="ch-container">
                                        <input type="checkbox" ${checked} onchange="insert_cate_group_wh('${group_code}', '${ item.code }', this.checked)">
                                        <span class="ch-checkmark"></span>
                                    </label></td>
                                <td>${ item.code }</td>
                                <td>${ item.name_1 }</td>
                            </tr>`);
                });
            }
        })
    }

    function delete_cate_group_wh(warehouse_code, group_code) {
        $.ajax({
            url: "{{ route('delete-group-wh') }}",
            type: 'POST',
            data: {
                'group_code': group_code,
                'warehouse_code': warehouse_code
            },
            success: function(e) {
                $.unblockUI();
                load_group_wh(group_code);
            }
        });
    }

    function set_add_cate_group_wh(group_code) {
        $("#group_code").val(group_code);
    }

    function insert_cate_group_wh(group_code, warehouse_code, checked) {
        $("#btn-close-modal").click();
        if (checked == true) {
            $.blockUI({
                message: ''
            });
            //let group_code = $("#group_code").val();
            $.ajax({
                url: "{{ route('save-group-wh') }}",
                type: 'POST',
                data: {
                    'group_code': group_code,
                    'warehouse_code': warehouse_code
                },
                success: function(e) {
                    $.unblockUI();
                    load_group_wh(group_code);
                }
            })
        } else {
            delete_cate_group_wh(warehouse_code, group_code);
        }
    }
</script>
