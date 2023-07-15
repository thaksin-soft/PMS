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
                        <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ກວດສອບສິນຄ້າເພີ່ມໃໝ່</h4>
                        <hr>
                        <div id="show"></div>

                    </div>
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
                            load_data();
                        }
                    });
                }
            });
        });
    });

    load_data();

    function load_data() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-purchasing-for-check') }}",
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
                            <td width="100">
                                <a href="{{ url('show-inventory/${ pro_item.doc_no }/${ pro_item.code }') }}" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                        </tr>`;
                    });
                    let button = '';
                    if (item.ch_status == 1) {
                        button = `
                        <a class="btn btn-success btn-sm" href="#" data-toggle="modal" onclick="send_to_accounting(${ item.doc_no })"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    ສົ່ງໃຫ້ບັນຊີຜູກເລກບັນຊີ </a>
                        &nbsp &nbsp
                                <button class="btn btn-danger btn-sm" onclick="send_back_to_edit(${ item.doc_no })"><i class="fa fa-reply-all" aria-hidden="true"></i>
                                    ສົ່ງກັບໄປແກ້ໄຂ</button>`;
                    } else if (item.ch_status == 3) {
                        button = `<a class="btn btn-warning btn-sm" href="{{ url('approve-inventory/${ item.doc_no }') }}"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    ຂໍ້ມູນຖືກຕ້ອງ ສົ່ງໃຫ້ IT </a>`;
                    } else if (item.ch_status == 2) {
                        button = `<span class="text-warning">ລໍຖ້າບັນຊີຜຸກບັນຊີ....</span>`;
                    }
                    $('#show').append(`
                            <h6>ເລກທີ່ເອກະສານ:​ <span class="text-primary">${ item.doc_no }</span> &nbsp &nbsp &nbsp
                                ເພີ່ມໂດຍ:
                                <span class="text-primary">${ item.emp_name } [${ item.code_fb }]</span>
                                    &nbsp &nbsp ${button}
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

    function send_back_to_edit(doc_no) {
        Swal.fire({
            title: `<span class="lao-font">ຢືັນຢັນ</span> ?`,
            html: `<span class="lao-font text-danger">ຢືນຢັນຂໍ້ມູນບໍ່ຖືກຕ້ອງ ສົ່ງກັບໄປແກ້ໄຂ</span>`,
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
                    url: "{{ route('send-purchase-back-edit') }}",
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

    function send_to_accounting(doc_no) {
        Swal.fire({
            title: `<span class="lao-font">ຢືັນຢັນ</span> ?`,
            html: `<span class="lao-font text-warning">ຢືນຢັນສົ່ງຂໍ້ມູນໃຫ້ບັບຊີຜຸກເລກບັນຊີ !!</span>`,
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
                    url: "{{ route('send-purchase-to-accounting') }}",
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
</script>
