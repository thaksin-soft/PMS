<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ສິນຄ້າເພີ່ມໃໝ່ພ້ອມອັບໂຫຼດ</h4>
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
    });
    load_data();

    function load_data() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-purchasing-for-upload') }}",
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
                    $('#show').append(`
                            <h6>ເລກທີ່ເອກະສານ:​ <span class="text-primary">${ item.doc_no }</span> &nbsp &nbsp &nbsp
                                ເພີ່ມໂດຍ:
                                <span class="text-primary">${ item.emp_name } [${ item.code_fb }]</span>
                                <button class="btn btn-warning btn-sm" onclick="upload_data('${ item.doc_no }')"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    upload ເຂົ້າລະບົບ</button>
                                
                                    &nbsp &nbsp
                                <button class="btn btn-danger btn-sm" onclick="send_back_to_edit('${ item.doc_no }')"><i class="fa fa-reply-all" aria-hidden="true"></i>
                                    ສົ່ງກັບໄປແກ້ໄຂ</button>
                                
                            </h6>
                            <table class="table">
                                <tr>
                                    <th width="50">ລຳດັບ</th>
                                    <th></th>
                                    <th>ຊື່ສິນຄ້າ</th>
                                    <th>ຫົວໜ່ວຍຍອດຄົງເຫຼືອ</th>
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
                        load_data();
                    }
                });
            }
        });
    }

    function upload_data(doc_no) {
        Swal.fire({
            title: `<span class="lao-font">ຢືັນຢັນ</span> ?`,
            html: `<span class="lao-font text-danger">ຢືນຢັນ upload ຂໍ້ມູນ ເລກທີ່: ${doc_no}</span>`,
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
                    url: "{{ route('upload-purchasing-product') }}",
                    type: 'POST',
                    data: {
                        'doc_no': doc_no
                    },
                    success: function(e) {
                        console.log(e);
                        $.unblockUI();
                        if (e == 'success') {
                            location.reload();
                        }
                    }
                });
            }
        });
    }
</script>
