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
                                <div class="col-sm-12">
                                    <table id="category-list" class="display table table-bordered" style="width:100%" >
                                        <thead>
                                            <tr>
                                                <th>ລໍາດັບ</th>
                                                <th>ລະຫັດ</th>
                                                <th>ປະເພດ</th>
                                                <th>ຄຸນສົມບັດ</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                        @foreach ($sql as $key =>$item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->name_1 }}</td>
                                            <td class="text-center"><a href="/attribute-index/{{ $item->code }}/{{ $item->name_1 }}" ><button type="button" class="btn btn-outline-info btn-sm"><i class="fa fa-eye"></i> ກົດ</button></a></td>

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
$(document).ready(function(e) {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
})






</script>
