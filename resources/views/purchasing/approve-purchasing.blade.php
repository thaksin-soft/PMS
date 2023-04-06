<x-app-layout>
    <script src="{{ asset('assets/prints/jquery-1.10.2.js') }}" type="text/JavaScript" language="javascript"></script>
    <script src="{{ asset('assets/prints/jquery-ui-1.10.4.custom.js') }}"></script>
    <script src="{{ asset('assets/prints/jquery.PrintArea.js') }}" type="text/JavaScript" language="javascript"></script>
    {{-- <script src="{{ asset('assets/prints/jQuery.print.js') }}" type="text/JavaScript" language="javascript"></script> --}}
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/prints/css/ui-lightness/jquery-ui-1.10.4.custom.css') }}" />

    <link type="text/css" rel="stylesheet" href="{{ asset('assets/prints/PrintArea.css') }}" />
    <!-- Y : rel is stylesheet and media is in [all,print,empty,undefined] -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 lao-font">
                    <div class="p-3">
                        <h4><i class="fa fa-info-circle" aria-hidden="true"></i> ຢືນຢັນຂໍ້ມູນສິນຄ້າຖືກຕ້ອງ</h4>
                        <hr>
                        <p class="text-danger"><b>Note:</b> ກ່ອນສົ່ງລາຍການສິນຄ້າໃຫ້ IT ເອົາຂື້ນລະບົບ
                            ກະລຸນາກວດສອບລາຍການສິນຄ້າທຸກລາຍການໃຫ້ຖືກຕ້ອງ</p>
                        <h6>ເລກທີ່ເອກະສານ:​ <span class="text-primary">{{ $doc_no }}</span></h6>

                        @if (Auth::user()->hasRole('purchasinghead'))
                            {{-- <button class="btn btn-info" data-toggle="modal" data-target="#modal-print"
                                onclick="load_bill_info_print({{ $doc_no }})"><i class="fa fa-print"
                                    aria-hidden="true"></i> ພິມ</button> --}}
                            <button class="btn btn-warning text-white"
                                onclick="confirm_approve_purchasing({{ $doc_no }})"><i class="fa fa-paper-plane-o"
                                    aria-hidden="true"></i>
                                ຢືນຢັນຂໍ້ມູນຖືກຕ້ອງ ແລະ ສົ່ງໃຫ້ IT ເຂົ້າລະບົບ</button>
                        @endif

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

    function confirm_approve_purchasing(doc_no) {
        Swal.fire({
            title: '<span class="lao-font">ຢືນຢັນ</span> ?',
            html: `<span class="lao-font text-danger">ຢືນຢັນ! ຂໍ້ມູນຖືກຕ້ອງ ສົ່ງໃຫ້ IT ອັບເຂົ້າລະບົບ</span>`,
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
                    url: "{{ route('confirm-approve-purchasing') }}",
                    type: 'POST',
                    data: {
                        'doc_no': doc_no
                    },
                    success: function(e) {
                        $.unblockUI();
                        if (e == 'success') {
                            window.location.href = '/';
                        }
                    }
                });
            }
        });
    }
</script>
