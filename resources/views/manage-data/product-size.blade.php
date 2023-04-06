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
                        <h5><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ເພີ່ມຂະໜາດສິນຄ້າ</h5>
                        <hr>

                        <div class="row">
                            <div class="col-sm-4">
                                <h5 class="text-center text-primary"><b class="text-danger">*</b> ປະເພດສິນຄ້າ (PH4)
                                </h5>
                                <div id="" style="overflow:scroll; height: 70vh;">
                                    <ul id="my-category">
                                        @foreach ($ic_category as $item)
                                            <li class="category" onclick="load_cate_size('{{ $item->code }}')">
                                                {{ $item->name_1 }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8" id="size-detail">
                                <div id="insert-cate-size">

                                </div>
                                <table class="table">
                                    <tr>
                                        <th width="50">ລຳດັບ</th>
                                        <th>ລະຫັດ</th>
                                        <th>ຊື່</th>
                                    </tr>
                                    <tbody id="table-show-size">

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
    <div class="modal" id="add-cate-size">
        <div class="modal-dialog">
            <div class="modal-content lao-font">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <input type="text" class="form-control" id="search-size" onkeyup="search_size()"
                        placeholder="ຄົ້ນຫາ...">
                    <input type="hidden" id="cate_code">
                    <table id="size-table" class="table">
                        <tr>
                            <th width="50">ເລືອກ</th>
                            <th>code</th>
                            <th>ຊື່ຂະໜາດ</th>
                        </tr>
                        <tbody id="ic-size"></tbody>


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
    function search_size() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-size");
        filter = input.value.toUpperCase();
        table = document.getElementById("size-table");
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

    function load_cate_size(cate_code) {
        $("#ic-size").html('');
        load_size(cate_code);
        $("#insert-cate-size").html(
            `<button class="btn btn-sm btn-info" onclick="set_add_cate_size('${cate_code}')" data-toggle="modal" data-target="#add-cate-size"><i class="fa fa-plus" aria-hidden="true"></i> ເພີ່ມຍີ່ຫໍ້ສິນຄ້າ</button>`
        );
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-cate-size') }}",
            type: 'POST',
            data: {
                'cate_code': cate_code
            },
            success: function(e) {
                $.unblockUI();
                $("#table-show-size").html('');
                $.each(e, function(index, item) {
                    $("#table-show-size").append(`<tr>
                                            <td>${index+1}</td>
                                            <td>${item.code}</td>
                                            <td>${item.name_1}</td>
                                            <td width="50"><a href="#" data-toggle="modal" class="text-danger" onclick="delete_cate_size('${item.code}', '${cate_code}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                        </tr>`);
                });
            }
        })
    }

    function load_size(cate_code) {
        $.ajax({
            url: "{{ route('load-size') }}",
            type: 'POST',
            data: {
                'cate_code': cate_code
            },
            success: function(e) {
                let ic_size = e.ic_size;
                let cate_size = e.cate_size;
                $.unblockUI();
                $("#ic-size").html('');
                $.each(ic_size, function(index, item) {
                    //ກວດສອບລາຍການທີ່ເພີ່ມແລ້ວ
                    let checked = '';
                    $.each(cate_size, function(j, ch_item) {
                        if (item.code == ch_item.size_code) {
                            checked = "checked";
                            return false;
                        }
                    });
                    ///////////////////

                    $("#ic-size").append(`<tr>
                                <td>
                                    <label class="ch-container">
                                        <input type="checkbox" ${checked} onchange="insert_cate_size('${cate_code}', '${ item.code }', this.checked)">
                                        <span class="ch-checkmark"></span>
                                    </label></td>
                                <td>${ item.code }</td>
                                <td>${ item.name_1 }</td>
                            </tr>`);
                });
            }
        })
    }

    function delete_cate_size(size_code, cate_code) {
        $.ajax({
            url: "{{ route('delete-cate-size') }}",
            type: 'POST',
            data: {
                'cate_code': cate_code,
                'size_code': size_code
            },
            success: function(e) {
                $.unblockUI();
                load_cate_size(cate_code);
            }
        });
    }

    function set_add_cate_size(cate_code) {
        $("#cate_code").val(cate_code);

    }

    function insert_cate_size(cate_code, size_code, checked) {
        $("#btn-close-modal").click();
        if (checked == true) {
            $.blockUI({
                message: ''
            });
            //let cate_code = $("#cate_code").val();
            $.ajax({
                url: "{{ route('save-cate-size') }}",
                type: 'POST',
                data: {
                    'cate_code': cate_code,
                    'size_code': size_code
                },
                success: function(e) {
                    $.unblockUI();
                    load_cate_size(cate_code);
                }
            })
        } else {
            delete_cate_size(size_code, cate_code);
        }
    }
</script>
