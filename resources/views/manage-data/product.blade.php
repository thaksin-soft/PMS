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
                                <h5 class="text-center text-primary"><b class="text-danger">*</b> ປະເພດສິນຄ້າ (PH4)
                                </h5>
                                <div id="" style="overflow:scroll; height: 70vh;">
                                    <ul id="my-category">
                                        @foreach ($ic_category as $item)
                                            <li class="category"
                                                onclick="load_cate_product('{{ $item->code }}')">
                                                {{ $item->name_1 }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8" id="product-detail">
                                <div id="insert-cate-product">

                                </div>
                                <table class="table">
                                    <tr>
                                        <th width="50">ລຳດັບ</th>
                                        <th>ລະຫັດ</th>
                                        <th>ຊື່ສິນຄ້າ</th>
                                    </tr>
                                    <tbody id="table-show-product">

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
    <div class="modal" id="add-cate-product">
        <div class="modal-dialog">
            <div class="modal-content lao-font">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4>ເພີ່ມຊື່ສິນຄ້າ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <form action="" id="form-add-product">
                        @csrf
                        <label for="product_code">ລະຫັດປະເພດສິນຄ້າ</label>
                        <input type="text" id="cate_code" class="form-control" name="category_code" readonly><br>
                        <label for="product_code">ລະຫັດສິນຄ້າ</label>
                        <input type="text" class="form-control" name="product_code" id="product_code" readonly><br>
                        <label for="product_name">ຊື່ສິນຄ້າ</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" required><br>
                        <button class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                            ບັນທຶກ</button>
                    </form>

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
    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#form-add-product").submit(function(e) {
            e.preventDefault();
            $("#btn-close-modal").click();
            $.blockUI({
                message: ''
            });
            let cate_code = $("#cate_code").val();
            $.ajax({
                url: "{{ route('save-product') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(e) {
                    $.unblockUI();
                    load_cate_product(cate_code);
                }
            })
        });
    });
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

    function load_cate_product(cate_code) {
        $("#ic-product").html('');
        $("#insert-cate-product").html(
            `<button class="btn btn-sm btn-info" onclick="set_add_cate_product('${cate_code}')" data-toggle="modal" data-target="#add-cate-product"><i class="fa fa-plus" aria-hidden="true"></i> ເພີ່ມຊື່ສິນຄ້າ</button>`
        );
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-product') }}",
            type: 'POST',
            data: {
                'cate_code': cate_code
            },
            success: function(e) {
                $.unblockUI();
                $("#table-show-product").html('');
                $.each(e, function(index, item) {
                    $("#table-show-product").append(`<tr>
                                            <td>${index+1}</td>
                                            <td>${item.product_code}</td>
                                            <td>${item.product_name} <a href="#" data-toggle="modal" class="text-warning" onclick="edit_product('${item.product_code}', '${item.product_name}', '${cate_code}')"><i class="fa fa-pencil" aria-hidden="true"></i> ແກ້ໄຂ</a></td>
                                            <td width="50"><a href="#" data-toggle="modal" class="text-danger" onclick="delete_cate_product('${item.product_code}', '${cate_code}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                        </tr>`);
                });
            }
        });
    }

    function edit_product(code, name, cate_code) {
        Swal.fire({
            title: '<span class="lao-font">ແກ້ໄຂ</span>',
            input: 'text',
            inputValue: name,
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'OK',
            showLoaderOnConfirm: true,
            preConfirm: (new_value) => {
                $.blockUI({
                    message: ''
                });
                $.ajax({
                    url: "{{ route('edit-product') }}",
                    type: 'POST',
                    data: {
                        'code': code,
                        'name': new_value
                    },
                    success: function(e) {
                        $.unblockUI();
                        load_cate_product(cate_code);
                    }
                });
            },
        })
    }

    function delete_cate_product(product_code, cate_code) {
        Swal.fire({
            title: '<span class="lao-font">ຢືນຢັນການລຶບ</span> ?',
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
                    url: "{{ route('delete-product') }}",
                    type: 'POST',
                    data: {
                        'cate_code': cate_code,
                        'product_code': product_code
                    },
                    success: function(e) {
                        $.unblockUI();
                        load_cate_product(cate_code);
                    }
                });
            }
        })

    }

    function set_add_cate_product(cate_code) {
        $("#cate_code").val(cate_code);
        let qty = $('#table-show-product tr').length + 1;
        if (qty < 10) {
            qty = '00' + qty;
        } else if (qty < 100) {
            qty = '0' + qty;
        }
        $("#product_code").val(cate_code + "-" + qty);
    }
</script>
