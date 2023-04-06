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
                        <h5><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ເພີ່ມແບບສິນຄ້າ</h5>
                        <hr>

                        <div class="row">
                            <div class="col-sm-4">
                                <h5 class="text-center text-primary"><b class="text-danger">*</b> ປະເພດສິນຄ້າ (PH4)
                                </h5>
                                <div id="" style="overflow:scroll; height: 70vh;">
                                    <ul id="my-category">
                                        @foreach ($ic_category as $item)
                                            <li class="category"
                                                onclick="load_cate_pattern('{{ $item->code }}')">
                                                {{ $item->name_1 }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8" id="pattern-detail">
                                <div id="insert-cate-pattern">

                                </div>
                                <table class="table">
                                    <tr>
                                        <th width="50">ລຳດັບ</th>
                                        <th>ລະຫັດ</th>
                                        <th>ຊື່</th>
                                    </tr>
                                    <tbody id="table-show-pattern">

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
    <div class="modal" id="add-cate-pattern">
        <div class="modal-dialog">
            <div class="modal-content lao-font">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <input type="text" class="form-control" id="search-pattern" onkeyup="search_pattern()"
                        placeholder="ຄົ້ນຫາ...">
                    <input type="hidden" id="cate_code">
                    <table id="pattern-table" class="table">
                        <tr>
                            <th width="50">ເລືອກ</th>
                            <th>code</th>
                            <th>ຊື່ແບບ</th>
                        </tr>
                        <tbody id="ic-pattern"></tbody>


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
    function search_pattern() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-pattern");
        filter = input.value.toUpperCase();
        table = document.getElementById("pattern-table");
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

    function load_cate_pattern(cate_code) {
        $("#ic-pattern").html('');
        load_pattern(cate_code);
        $("#insert-cate-pattern").html(
            `<button class="btn btn-sm btn-info" onclick="set_add_cate_pattern('${cate_code}')" data-toggle="modal" data-target="#add-cate-pattern"><i class="fa fa-plus" aria-hidden="true"></i> ເພີ່ມຍີ່ຫໍ້ສິນຄ້າ</button>`
        );
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-cate-pattern') }}",
            type: 'POST',
            data: {
                'cate_code': cate_code
            },
            success: function(e) {
                $.unblockUI();
                $("#table-show-pattern").html('');
                $.each(e, function(index, item) {
                    $("#table-show-pattern").append(`<tr>
                                            <td>${index+1}</td>
                                            <td>${item.code}</td>
                                            <td>${item.name_1}</td>
                                            <td width="50"><a href="#" data-toggle="modal" class="text-danger" onclick="delete_cate_pattern('${item.code}', '${cate_code}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                        </tr>`);
                });
            }
        })
    }

    function load_pattern(cate_code) {
        $.ajax({
            url: "{{ route('load-pattern') }}",
            type: 'POST',
            data: {
                'cate_code': cate_code
            },
            success: function(e) {
                let ic_pattern = e.ic_pattern;
                let cate_pattern = e.cate_pattern;
                $.unblockUI();
                $("#ic-pattern").html('');
                $.each(ic_pattern, function(index, item) {
                    //ກວດສອບລາຍການທີ່ເພີ່ມແລ້ວ
                    let checked = '';
                    $.each(cate_pattern, function(j, ch_item) {
                        if (item.code == ch_item.pattern_code) {
                            checked = "checked";
                            return false;
                        }
                    });
                    ///////////////////

                    $("#ic-pattern").append(`<tr>
                                <td>
                                    <label class="ch-container">
                                        <input type="checkbox" ${checked} onchange="insert_cate_pattern('${cate_code}', '${ item.code }', this.checked)">
                                        <span class="ch-checkmark"></span>
                                    </label></td>
                                <td>${ item.code }</td>
                                <td>${ item.name_1 }</td>
                            </tr>`);
                });
            }
        })
    }

    function delete_cate_pattern(pattern_code, cate_code) {
        $.ajax({
            url: "{{ route('delete-cate-pattern') }}",
            type: 'POST',
            data: {
                'cate_code': cate_code,
                'pattern_code': pattern_code
            },
            success: function(e) {
                $.unblockUI();
                load_cate_pattern(cate_code);
            }
        });
    }

    function set_add_cate_pattern(cate_code) {
        $("#cate_code").val(cate_code);

    }

    function insert_cate_pattern(cate_code, pattern_code, checked) {
        $("#btn-close-modal").click();
        if (checked == true) {
            $.blockUI({
                message: ''
            });
            //let cate_code = $("#cate_code").val();
            $.ajax({
                url: "{{ route('save-cate-pattern') }}",
                type: 'POST',
                data: {
                    'cate_code': cate_code,
                    'pattern_code': pattern_code
                },
                success: function(e) {
                    $.unblockUI();
                    load_cate_pattern(cate_code);
                }
            })
        } else {
            delete_cate_pattern(pattern_code, cate_code);
        }
    }
</script>
