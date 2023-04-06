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
                        <h5><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ເພີ່ມປະເພດສິນຄ້າ</h5>
                        <hr>

                        <div class="row">
                            <div class="col-sm-4">
                                <h5 class="text-center text-primary"><b class="text-danger">*</b> ໝວດສິນຄ້າຍ່ອຍ2 (PH3)
                                </h5>
                                <div id="" style="overflow:scroll; height: 70vh;">
                                    <ul id="my-category">
                                        @foreach ($group_sub2 as $item)
                                            <li class="category"
                                                onclick="load_product_category('{{ $item->code }}')">
                                                {{ $item->name_1 }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8" id="category-detail">
                                <div id="insert-product-cate">

                                </div>
                                <table class="table">
                                    <tr>
                                        <th width="50">ລຳດັບ</th>
                                        <th>ລະຫັດ</th>
                                        <th>ຊື່</th>
                                    </tr>
                                    <tbody id="table-show-category">

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
    <div class="modal" id="add-product-cate">
        <div class="modal-dialog">
            <div class="modal-content lao-font">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <input type="text" class="form-control" id="search-category" onkeyup="search_category()"
                        placeholder="ຄົ້ນຫາ...">
                    <input type="hidden" id="sub2_code">
                    <table id="category-table" class="table">
                        <tr>
                            <th width="50">ເລືອກ</th>
                            <th>code</th>
                            <th>ປະເພດສິນຄ້າ (PH4)</th>
                        </tr>
                        <tbody id="ic-category"></tbody>


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
    function search_category() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-category");
        filter = input.value.toUpperCase();
        table = document.getElementById("category-table");
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

    function load_product_category(sub2_code) {
        $("#ic-category").html('');
        load_category(sub2_code);
        $("#insert-product-cate").html(
            `<button class="btn btn-sm btn-info" onclick="set_add_product_category('${sub2_code}')" data-toggle="modal" data-target="#add-product-cate"><i class="fa fa-plus" aria-hidden="true"></i> ປະເພດສິນຄ້າ (PH4)</button>`
        );
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-product-cate') }}",
            type: 'POST',
            data: {
                'sub2_code': sub2_code
            },
            success: function(e) {
                $.unblockUI();
                $("#table-show-category").html('');
                $.each(e, function(index, item) {
                    $("#table-show-category").append(`<tr>
                                            <td>${index+1}</td>
                                            <td>${item.code}</td>
                                            <td>${item.name_1}</td>
                                            <td width="50"><a href="#" data-toggle="modal" class="text-danger" onclick="delete_product_category('${item.code}', '${sub2_code}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                        </tr>`);
                });
            }
        })
    }

    function load_category(sub2_code) {
        $.ajax({
            url: "{{ route('load-category') }}",
            type: 'POST',
            data: {
                'sub2_code': sub2_code
            },
            success: function(e) {
                let ic_category = e.ic_category;
                let product_category = e.product_category;
                $.unblockUI();
                $("#ic-category").html('');
                $.each(ic_category, function(index, item) {
                    //ກວດສອບລາຍການທີ່ເພີ່ມແລ້ວ
                    let checked = '';
                    $.each(product_category, function(j, ch_item) {
                        if (item.code == ch_item.category_code) {
                            checked = "checked";
                            return false;
                        }
                    });
                    ///////////////////

                    $("#ic-category").append(`<tr>
                                <td>
                                    <label class="ch-container">
                                        <input type="checkbox" ${checked} onchange="insert_product_category('${sub2_code}', '${ item.code }', this.checked)">
                                        <span class="ch-checkmark"></span>
                                    </label></td>
                                <td>${ item.code }</td>
                                <td>${ item.name_1 }</td>
                            </tr>`);
                });
            }
        })
    }

    function delete_product_category(category_code, sub2_code) {
        $.ajax({
            url: "{{ route('delete-product-cate') }}",
            type: 'POST',
            data: {
                'sub2_code': sub2_code,
                'category_code': category_code
            },
            success: function(e) {
                $.unblockUI();
                load_product_category(sub2_code);
            }
        });
    }

    function set_add_product_category(sub2_code) {
        $("#sub2_code").val(sub2_code);
    }

    function insert_product_category(sub2_code, category_code, checked) {
        $("#btn-close-modal").click();
        if (checked == true) {
            $.blockUI({
                message: ''
            });
            $.ajax({
                url: "{{ route('save-product-cate') }}",
                type: 'POST',
                data: {
                    'sub2_code': sub2_code,
                    'category_code': category_code
                },
                success: function(e) {
                    $.unblockUI();
                    load_product_category(sub2_code);
                }
            })
        } else {
            delete_product_category(category_code, sub2_code);
        }
    }
</script>
