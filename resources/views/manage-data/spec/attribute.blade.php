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

        table {
              border-collapse: collapse;
            }

            input[type=text] {
              padding:10px;
              box-shadow:0 0 15px 4px rgba(0,0,0,0.06);
            }

            .rounded-input {
              padding:10px;
              border-radius:10px;
            }

            a {
              color: #000000;
            }
            
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="p-3 lao-font">
                        <hr>
                        <div class="content">
                            <div class="container-fluid">
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="card card-primary card-outline">
                                    <div class="card-body lao-font">
                                      <div class="row">
                                      <h5 class="card-title">ເພີ້ມຂໍ້ມູນ</h5><button type="button" class="btn btn-danger ml-auto"><a href="{{ route('category-index')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></button></div><br>
      
                                     <div class="form-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">ປະເພດສິນຄ້າ :</span>
                                        <input type="hidden" class="form-control" name="cat_code" readonly value="{{ $sql_cat[0]->code }}"> 
                                        <input type="text" class="form-control" name="cat_name" readonly value="{{ $sql_cat[0]->name_1 }}"> 
                                      </div>
                                     </div>
                                      <form action="/attribute-save" method="POST">
                                        @csrf
                                        <input type="hidden" name="cat_id" id="cat_id" value="{{ $sql_cat[0]->code }}">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">ຄຸນສົມບັດ(ລາວ)</label>
                                          <input type="text" name="filedname_lao" id="filedname_lao" class="form-control rounded-input">
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">ຄຸນສົມບັດ(ອັງກິດ)</label>
                                          <input type="text" name="filedname" id="filedname" class="form-control rounded-input">
                                        </div>
                                        <button type="submit" class="btn btn-info">ບັນທຶກ</button>
                                      </form>
                                  
                                    </div>
                                  </div><!-- /.card -->
                                </div>

                                <div class="col-sm-8">
                                  <table class="table">
                                    <tr>
                                        <th width="50">ລຳດັບ</th>
                                        <th>ຊື່ປະເພດ(ລາວ)</th>
                                        <th>ຊື່ປະເພດ(ອັງກິດ)</th>
                                        <th>ຈັດການ</th>
                                    </tr>
                                    <tbody id="categorylist">
                                      @foreach ($sql as $key => $item)
                                      <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->filedname_lao }}</td>
                                        <td>{{ $item->filedname }}</td>
                                        <td>
                                          <a href="#" onclick="at_edit('{{ $item->filedname_lao }}','{{ $item->filedname }}')">ແກ້ໄຂ</a>
                                        </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                                </div>
                              </div>
                              <!-- /.row -->
                            </div><!-- /.container-fluid -->
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ປະເພດສິນຄ້າ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tr>
              <th width="50">ລຳດັບ</th>
              <th>ລະຫັດ</th>
              <th>ຊື່ປະເພດ</th>
              <th>ເລືອກ</th>
          </tr>
          <tbody id="categorylist">
          </tbody>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</x-app-layout>
<script>

function at_edit(filed_lao,filed_name) {
        var name_lao = document.getElementById("filed_lao");
        var filed_namee = document.getElementById("filed_name");


        name_lao.value = filed_lao;
        filed_namee.value = filed_name;

    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


function category(){
        $.ajax({
            url: "{{ route('category') }}",
            method: "get",
            success: function(e) {
               $('#categorylist').html('');
                    $.each(e, function(index, item) {
                      console.log(e);
                        $('#categorylist').append(`<tr>
                                <td>${index+1}</td>
                                <td>${item.code}</td>
                                <td>${item.name_1}</td>
                                <td><a href="#" onclick="">ເລືອກ</a></td>
                            </tr>`);
                    });
            }
        })
    }


<script>