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
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
              <div class="x_title">
                <h2 class="lao-font">ຍີ່ຫໍ້ສິນຄ້າ</h2> &nbsp;&nbsp;<a href="{{ route('brands-create')}}"><button type="button" class="btn btn-success btn-sm lao-font">ເພີ້ມ</button></a>
                @if ($message = Session::get('success'))
                                            <div class="alert alert-success alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>	
                                                    <strong>{{ $message }}</strong>
                                            </div>
                @endif
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="row">
                      <div class="col-sm-12">
                        <div class="card-box table-responsive">
                <table id="datatable-fixed-header" class="table table-striped table-bordered lao-font" style="width:100%">
                  <thead>
                    <tr>
                      <th>ລໍາດັບ</th>
                      <th>ລະຫັດ</th>
                      <th>ຍີ່ຫໍ້</th>
                      <th>ຈັດການ</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($brand as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->name_1 }}</td>
                        <td>AAA</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
            </div>
          </div>
</x-app-layout>
