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
<div class="card-header text-center">
            <h4>ການໃສ່ຄຸນສົມບັດສິນຄ້າດ້ວຍ Excel</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('spec.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-primary">ນໍາເຂົ້າຄຸນສົມບັດສິນຄ້າ</button>
            </form>
  
            <table class="table table-bordered mt-3">
                <tr>
                    <div>
                    <th colspan="5">
                        ລາຍການສິນຄ້າ
                        
                        <a class="btn btn-danger  ml-auto" href="{{ route('spec.export') }}">ດາວໂຫຼດຂໍ້ມູນ</a>
                    </th>
                </div>
                </tr>
                <tr>
                    <th>ລໍາດັບ</th>
                    <th>ລະຫັດ</th>
                    <th>ລາຍການ</th>
                    <th>ຫົວໜ່ວຍ</th>
                    <th>ຍີ່ຫໍ້</th>
                    <th>ລຸ້ນ</th>
                    {{-- <th>size</th>
                    <th>color</th>
                    <th>weight</th>
                    <th>hight</th>
                    <th>width</th>
                    <th>lerk</th>
                    <th>inverter</th>
                    <th>acpower</th>
                    <th>remote</th>
                    <th>baipad</th>
                    <th>sticker</th>
                    <th>star</th>
                    <th>wifi</th>
                    <th>warranry</th>
                    <th>warranry2</th> --}}
                </tr>
                @foreach($Specs as $key => $Spec)
                <tr>
                    <td>{{ ++ $key }}</td>
                    <td>{{ $Spec->ic_code }}</td>
                    <td>{{ $Spec->name_1 }}</td>
                    <td>{{ $Spec->unit_code }}</td>
                    <td>{{ $Spec->brand }}</td>
                    <td>{{ $Spec->model }}</td>
                    {{-- <td>{{ $Spec->size }}</td>
                    <td>{{ $Spec->color }}</td>
                    <td>{{ $Spec->weight }}</td>
                    <td>{{ $Spec->hight }}</td>
                    <td>{{ $Spec->width }}</td>
                    <td>{{ $Spec->lerk }}</td>
                    <td>{{ $Spec->inverter }}</td>
                    <td>{{ $Spec->acpower }}</td>
                    <td>{{ $Spec->remote }}</td>
                    <td>{{ $Spec->baipad }}</td>
                    <td>{{ $Spec->sticker }}</td>
                    <td>{{ $Spec->star }}</td>
                    <td>{{ $Spec->wifi }}</td>
                    <td>{{ $Spec->warranry }}</td>
                    <td>{{ $Spec->warranry2 }}</td> --}}
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>
</x-app-layout>