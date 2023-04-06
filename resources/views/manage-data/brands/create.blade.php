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
                        <hr>
                        <div class="content">
                            <div class="container-fluid">
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="card card-primary card-outline">
                                    <div class="card-body lao-font">
                                      <h5 class="card-title">ຍີ່ຫໍ້ສິນຄ້າ</h5><br>
                                      @if ($message = Session::get('success'))
                                            <div class="alert alert-success alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>	
                                                    <strong>{{ $message }}</strong>
                                            </div>
                                            @endif
                                      <form action="{{ route('brands-save')}}" method="POST">
                                        @csrf
                                        <div class="card-body">
                                          <div class="form-group">
                                            <label for="colorname">ລະຫັດຍີ່ຫໍ້</label>
                                            <input type="text"  name="code" class="form-control" id="code" placeholder="ກະລຸນາໃສ່ ລະຫັດຍີ່ຫໍ້">
                                          </div>
                                          <div class="form-group">
                                            <label for="colorname">ຍີ່ຫໍ້ສິນຄ້າ(ລາວ)</label>
                                            <input type="text"  name="name_1" class="form-control" id="name" placeholder="ກະລຸນາໃສ່ ຍີ່ຫໍ້ສິນຄ້າ">
                                          </div>
                                          <div class="form-group">
                                            <label for="colorname">ຍີ່ຫໍ້ສິນຄ້າ(ໄທ)</label>
                                            <input type="text"  name="name_2" class="form-control" id="name" placeholder="ກະລຸນາໃສ່ ຍີ່ຫໍ້ສິນຄ້າໄທ">
                                          </div>
                                        </div>
                                        <!-- /.card-body -->
                        
                                        <div class="card-footer">
                                          <button type="submit" class="btn btn-primary">ບັນທຶກ</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div><!-- /.card -->
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
</x-app-layout>
