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


    <style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    .page-item.active .page-link{
        z-index: 3;
        color: #fff !important  ;
        background-color: #00ACD6 !important;
        border-color: #00ACD6 !important;
        border-radius: 50%;
        padding: 6px 12px;
    }
    .page-link{
        z-index: 3;
        color: #00ACD6 !important;
        background-color: #fff;
        border-color: #007bff;
        border-radius: 50%;
        padding: 6px 12px !important;
    }
    .page-item:first-child .page-link{
        border-radius: 30% !important;
    }
    .page-item:last-child .page-link{
        border-radius: 30% !important;   
    }
    .pagination li{
        padding: 3px;
    }
    .disabled .page-link{
        color: #212529 !important;
        opacity: 0.5 !important;
    }

</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="p-3 lao-font">
                        <h5><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ອັບໂຫລດສິນຄ້າທີ່ມີແລ້ວ </h5>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table" id="datatable">
                                <input type="text" name="search" id="search" class="form-control" placeholder="ຄົ້ນຫາສິນຄ້າ.....">
                                 
                              <div class="table-responsive">
                              <br/>
                                <h6 align="center"> ອັບສິນຄ້າທີ່ມີຢູ່ແລ້ວລະຫວ່າງຖານ ເພື່ອເອົາມາຈັດໂປຣໂມຊັນ <span id="total_records"></span></h3>
                                <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th>ລະຫັດສິນຄ້າ</th>
                                    <th>ລາຍການສິນຄ້າ</th>
                                    <th>ຫົວໜ່ວຍ</th>
                                    <th>ຍີ່ຫໍ້</th>
                                    <th>ຈັດການ</th>
                                    </tr>
                                </thead>
                                <tbody id="datalist">
                                </tbody>
                                </table>
                                </div>
                                </table>
                            </div>
                        </div>
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
  

$(document).ready(function(){

 product_data();

function product_data(query = '')
            {
            $.ajax({
            url:"{{ route('inventory.list') }}",
            method:'GET',
            data:{query:query},
            dataType:'json',
            success:function(data)
            {
               $("#datalist").html('');
               let datacheck ='';
                $.each(data, function(index, item) {

                 if (item.check_code==0) {
                           datacheck = `<a href="#" class="btn btn-danger btn-sm" onclick="product_save('${item.code}')"><i class="fa fa-save" aria-hidden="true"></i></a>`;
                }else {
                        datacheck = `<span>ມີໃນລະບົບແລ້ວ</span`;
                }

                    $("#datalist").append(`<tr>
                                            <td>${index+1}</td>
                                            <td>${item.code}</td>
                                            <td>${item.name_1}</td>
                                            <td>${item.unit_standard}</td>
                                            <td width="15%" class="text-center">${datacheck}</td>
                                        </tr>`);
                });
            }
            })
            }

            $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            product_data(query);
            });

        });


function product_save(item_code)
            {

            $.ajax({
            url:"{{ route('inventory.upload') }}",
            method:'POST',
            data:{item_code:item_code},
            success:function(e)
                {
                    if (e == 'success') {
                    swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '<span class="lao-font">ຄິດແລ້ວວ່າເຈົ້າຕ້ອງອ່ານ</span> <br> <span class="lao-font">ບັນທຶກສຳເລັດ</span>',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#datalist").html('');
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: '<span class="lao-font"> ບັນທຶກບໍ່ສຳເລັດ !!!!</span>',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                }
            })
        }
        
</script>
