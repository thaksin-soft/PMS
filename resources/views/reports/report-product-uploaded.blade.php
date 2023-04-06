<x-app-layout>
    <script src="{{ asset('assets/prints/jquery-1.10.2.js') }}" type="text/JavaScript" language="javascript"></script>
    <script src="{{ asset('assets/prints/jquery-ui-1.10.4.custom.js') }}"></script>
    <script src="{{ asset('assets/prints/jquery.PrintArea.js') }}" type="text/JavaScript" language="javascript"></script>
    {{-- <script src="{{ asset('assets/prints/jQuery.print.js') }}" type="text/JavaScript" language="javascript"></script> --}}
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/prints/css/ui-lightness/jquery-ui-1.10.4.custom.css') }}" />

    <link type="text/css" rel="stylesheet" href="{{ asset('assets/prints/PrintArea.css') }}" />
    <!-- Y : rel is stylesheet and media is in [all,print,empty,undefined] -->
    <style>
        .product-box {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            padding: 10px;
        }

    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ການອັບໂຫຼດສິນຄ້າ</h4>
                        <hr>
                        <div class="row">
                            @foreach ($product_upload as $item)
                                <div class="col-sm-4">
                                    <div class="product-box">
                                        <h6 class="text-center text-danger"><i class="fa fa-calendar"
                                                aria-hidden="true"></i> {{ $item->in_date }}</h6>
                                        <p>ເລກທີ່: <span class="text-primary">{{ $item->doc_no }}</span></p>
                                        <p>ເພິ່ມໂດຍ: <span class="text-primary">{{ $item->doc_no }}</span></p>
                                        <p>ກວດສອບໂດຍ: <span class="text-primary">{{ $item->doc_no }}</span></p>
                                        <p>ອັບໂຫຼດໂດຍ: <span class="text-primary">{{ $item->doc_no }}</span></p>
                                        <hr>
                                        <h6 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i>
                                            ຈຳນວນລາຍການ <span class="text-danger">100</span>
                                            ລາຍການ
                                        </h6>
                                        <a href="#" onclick="load_bill_info_print('{{ $item->doc_no }}')"
                                            data-toggle="modal" data-target="#modal-print"
                                            class="btn btn-info btn-sm"><i class="fa fa-eye"
                                                aria-hidden="true"></i> ລາຍລະອຽດ</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="modal-print">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="lao-font" style="border:1px solid; padding: 30px; color:black"
                                id="print-detail"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="SettingsBox">
                                <div style="width: 100%; padding: 20px;" class="lao-font">
                                    <div style="font-weight: bold; border-top: solid 1px #999fff; padding-top: 10px;">
                                        <i class="fa fa-cogs" aria-hidden="true"></i> ຕັ້ງຄ່າ
                                    </div>
                                    <table>
                                        <tbody>

                                            <tr>
                                                <td>
                                                    <div class="settingName">ພື້ນທີ່ພິມ:</div>
                                                    <div class="settingVals">
                                                        <input type="checkbox" class="selPA" value="title"
                                                            checked />
                                                        ສ່ວນຫົວ<br>
                                                        <input type="checkbox" class="selPA" value="content"
                                                            checked />
                                                        ສ່ວນລາຍລະອຽດ<br>
                                                        <input type="checkbox" class="selPA" value="footer"
                                                            checked />
                                                        ສ່ວນທ້າຍ<br>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div style="padding: 0 10px 10px;" class="buttonBar">
                                        {{-- <div class="button b1">Print</div> --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-primary b1"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
        $("button.b1").click(function() {
            var mode = "iframe";
            var close = mode == "popup" && $("input#closePop").is(":checked");
            var extraCss = null;

            //ເກັບເອົາພື້ນທີ່ທີ່ຕ້ອງການພິມ 
            var print = "";
            $("input.selPA:checked").each(function() {
                print += (print.length > 0 ? "," : "") + "div.PrintArea." + $(this).val();
            });

            //ເກັບເອົາຄຸນສົມຂອງບິນໃນການພິມ
            var keepAttr = [];

            var headElements =
                '<meta charset="utf-8" />,<meta http-equiv="X-UA-Compatible" content="IE=edge"/>';
            var options = {
                mode: mode,
                popClose: close,
                extraCss: extraCss,
                retainAttr: keepAttr,
                extraHead: false,
                //Log to console when printing is done via a deffered callback
                deferred: $.Deferred().done(function() {
                    console.log('Printing done', arguments);
                })
            };
            $(print).printArea(options);

        });
    });

    function load_bill_info_print(doc_no) {
        $("#print-detail").html('');
        $.ajax({
            url: "{{ route('load-data-detail') }}",
            type: "POST",
            data: {
                'doc_no': doc_no,
            },
            success: function(e) {
                $.unblockUI();
                let data = e.product;
                let purchasing = e.purchasing;
                let checker = e.checker;
                let base = e.base;
                let icon = 'pp-icon.png';
                if (base == 'od') {
                    icon = 'odien-icon.png';
                }

                let detail = '';
                $.each(data, function(i, item) {
                    detail = detail + `<tr>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">${(i+1)}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">[${item.code}] ${item.name_1}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px; ">${item.unit_standard}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">${item.ph1}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">${item.ph2}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">${item.ph3}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">${item.ph4}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">${item.ph5}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">${item.ph6}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">${item.ph7}</td>
                    <td style="font-family: 'Saysettha OT';color:black;border:1px solid black;padding:5px;">${item.ph8}</td>
                    </tr>`;
                });
                $("#print-detail").html(`<div class="PrintArea title" id="Retain">
                                    <div style="border: 1px solid; border-radius: 10px" class="mb-5 p-2">
                                        <table>
                                            <tr>
                                                <td><span class="mr-2"><img
                                                            src="{{ asset('images/${icon}') }}" alt=""
                                                            width="100"></span>
                                                </td>
                                                <td>
                                                    <p class="m-0" style="font-family: 'Saysettha OT';color:black;">ເລກທີ່: ${doc_no}
                                                    </p>
                                                    <p class="m-0" style="font-family: 'Saysettha OT';color:black;">ວັນທີ່ສ້າງ: ${purchasing[0].in_date}
                                                    </p>
                                                    <p class="m-0" style="font-family: 'Saysettha OT';color:black;">ເພີ່ມຂໍ້ມູນໂດຍ: ${purchasing[0].emp_name}
                                                    </p>
                                                    <p class="m-0" style="font-family: 'Saysettha OT';color:black;">ກວດສອບໂດຍ: ${checker[0].emp_name}</p>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <div class="PrintArea content" style="border-color: #999;">
                                    <h3 class="text-center" style="font-family: 'Saysettha OT';color:black">ໃບອະນຸມັດເພີ່ມສິນຄ້າໃໝ່</h3>
                                    <br>
                                    <table style="width:100%">
                                        <tr>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;" width="50">ລຳດັບ</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;" width="100">ຊື່ສິນຄ້າ</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;">ຫົວໜ່ວຍຍອດຄົງເຫຼືອ</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;">ph1</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;">ph2</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;">ph3</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;">ph4</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;">ph5</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;">ph6</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;">ph7</th>
                                            <th style="font-family: 'Saysettha OT'; border:1px solid black;padding:5px;">ph8</th>
                                        </tr>
                                        <tbody id="table-bill-product">${detail}</tbody>
                                    </table>

                                </div>
                                <div class="PrintArea footer">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="p-3">
                                                <h6 class="text-center" style="font-family: 'Saysettha OT';color:black">ຜູ້ອັບໂຫຼດ </h6>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="p-3">
                                                <h6 class="text-center" style="font-family: 'Saysettha OT';color:black">
                                                    ຜູ້ກວດສອບ
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="p-3">
                                                <h6 class="text-center" style="font-family: 'Saysettha OT';color:black">
                                                    ຜູ້ສະເໜີ
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
            }
        });
    }
</script>
