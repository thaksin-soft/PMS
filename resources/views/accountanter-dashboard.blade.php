<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ສິນຄ້າໃໝ່ພ້ອມຜຸກບັນຊີ</h4>
                        <hr>
                        <div id="show"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="modal-add-account">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body lao-font">
                    <input type="hidden" id="pi_no">
                    <input type="hidden" id="acount_index">
                    <input type="hidden" id="acount_col">
                    <div class="row">
                        <div class="col-sm-5">
                            <input type="text" id="search-code" class="form-control" onkeyup="search_by_code()"
                                placeholder="ຄົ້ນດ້ວຍ ລະຫັດ...">
                        </div>
                        <div class="col-sm-7">
                            <input type="text" id="search-name" class="form-control" onkeyup="search_by_name()"
                                placeholder="ຄົ້ນດ້ວຍ ຊື່...">
                        </div>
                    </div>
                    <table class="table">
                        <tr>
                            <th></th>
                            <th>ລະຫັດ</th>
                            <th>ຊື່</th>
                        </tr>
                        <tbody id="chat-of-account">

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
    function search_by_code() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-code");
        filter = input.value.toUpperCase();
        table = document.getElementById("chat-of-account");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
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

    function search_by_name() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-name");
        filter = input.value.toUpperCase();
        table = document.getElementById("chat-of-account");
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
    });
    load_data();

    function load_data() {
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('load-purchasing-for-join-account') }}",
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
                            <td class="text-danger"><span id="account-code-1-${key}">${pro_item.account_code_1}</span> <a href="#" data-toggle="modal" data-target="#modal-add-account" onclick="set_add_accounting(${pro_item.pi_no}, 1, ${key})"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                            <td class="text-danger"><span id="account-code-2-${key}">${pro_item.account_code_2}</span> <a href="#" data-toggle="modal" data-target="#modal-add-account" onclick="set_add_accounting(${pro_item.pi_no}, 2, ${key})"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                            <td class="text-danger"><span id="account-code-3-${key}">${pro_item.account_code_3}</span> <a href="#" data-toggle="modal" data-target="#modal-add-account" onclick="set_add_accounting(${pro_item.pi_no}, 3, ${key})"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                            <td class="text-danger"><span id="account-code-4-${key}">${pro_item.account_code_4}</span> <a href="#" data-toggle="modal" data-target="#modal-add-account" onclick="set_add_accounting(${pro_item.pi_no}, 4, ${key})"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                            <td width="50">
                                <a href="{{ url('show-inventory/${ pro_item.doc_no }/${ pro_item.code }') }}" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                        </tr>`;
                    });
                    $('#show').append(`
                            <h6>ເລກທີ່ເອກະສານ:​ <span class="text-primary">${ item.doc_no }</span> &nbsp &nbsp &nbsp
                                ເພີ່ມໂດຍ:
                                <span class="text-primary">${ item.emp_name } [${ item.code_fb }]</span>

                                <button class="btn btn-danger btn-sm" onclick="confirm_join_success(${ item.doc_no })"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    ຜຸກບັນຊີສຳເລັດ</button>
                                    &nbsp &nbsp
                                <button class="btn btn-danger btn-sm" onclick="send_back_to_edit(${ item.doc_no })"><i class="fa fa-reply-all" aria-hidden="true"></i>
                                    ສົ່ງກັບໄປແກ້ໄຂ</button>

                            </h6>
                            <table class="table">
                                <tr>
                                    <th width="50">ລຳດັບ</th>
                                    <th></th>
                                    <th>ຊື່ສິນຄ້າ</th>
                                    <th>ຫົວໜ່ວຍຍອດຄົງເຫຼືອ</th>
                                    <th>ລະຫັດຜັງບັນຊີສິນຄ້າ</th>
                                    <th>ລະຫັດຜັງບັນຊີຕົ້ນທຶນ</th>
                                    <th>ລະຫັດຜັງບັນຊີລາຍໄດ້</th>
                                    <th>ລະຫັດຜັງບັນຊີຮັບຄືນ</th>
                                    <th></th>
                                </tr>
                                <tbody id="table-${item.doc_no}">${pro_detail}</tbody>
                    </table>`);
                });
            }
        });
    }

    function set_add_accounting(pi_no, acount_index, col) {
        $("#pi_no").val(pi_no);
        $("#acount_index").val(acount_index);
        $("#acount_col").val(col);
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

    function confirm_join_success(doc_no) {
        let qty_product = $("#table-" + doc_no + " tr").length;
        for (let i = 0; i < qty_product; i++) {
            let ch1 = $("#account-code-1-" + i).html();
            let ch2 = $("#account-code-2-" + i).html();
            let ch3 = $("#account-code-3-" + i).html();
            let ch4 = $("#account-code-4-" + i).html();
            if (ch1 == '' || ch2 == '' || ch3 == '' || ch4 == '') {
                i = qty_product;
                Swal.fire({
                    icon: 'error',
                    title: '<span class="lao-font">ແຈ້ງເຕືອນ !</span>',
                    html: '<span class="lao-font text-danger">ກະລຸນາຜຸກບັນຊີໃຫ້ຄົບກ່ອນ !!!!!!!!!!</span>'
                });
                return;
            }
        }
        Swal.fire({
            title: `<span class="lao-font">ຢືັນຢັນ</span> ?`,
            html: `<span class="lao-font text-danger">ຢືນຢັນເພີ່ມລະຫັດບັນຊີສຳເລັດ !!!</span>`,
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
                    url: "{{ route('confirm-join-accounting') }}",
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
    load_chat_of_account();

    function load_chat_of_account() {
        $.ajax({
            url: "{{ route('load-chat-of-account') }}",
            type: 'GET',
            success: function(e) {
                $.each(e, function(index, item) {
                    $("#chat-of-account").append(`<tr>
                                <td><button class="btn btn-sm btn-info" data-dismiss="modal" onclick="add_account_to_purchase('${item.code}')">ເລືອກ</button></td>
                                <td>${item.code}</td>
                                <td>${item.name_1}</td>
                            </tr>`);
                })
            }
        });
    }

    function add_account_to_purchase(account_code) {
        let account_index = $("#acount_index").val();
        let col = $("#acount_col").val();
        let pi_no = $("#pi_no").val();
        $.blockUI({
            message: ''
        });
        $.ajax({
            url: "{{ route('add-chat-of-account-to-pur') }}",
            type: 'POST',
            data: {
                'ac_index': account_index,
                'pi_no': pi_no,
                'ac_code': account_code
            },
            success: function(e) {
                $.unblockUI();
                console.log(e);
                $("#account-code-" + account_index + "-" + col).html(account_code);
                /* if (e == 'success') {
                    load_data();
                } */
            }
        });
    }
</script>
