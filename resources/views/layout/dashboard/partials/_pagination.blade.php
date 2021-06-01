<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script>

    window.pdfMake = window.pdfMake || {};
    window.pdfMake.vfs = {
        "{{ asset('dash_assets/Frutiger/FrutigerLTArabic-55Roman.ttf')}}": "AAEAAAASAQAABAAgR0RFRtRX1"
    }
    window.pdfMake.vfs["{{ asset('dash_assets/Frutiger/FrutigerLTArabic-55Roman.ttf')}}"] = "BASE 64 HERE";

    pdfMake.fonts = {
        Arial: {
            normal: 'arial.ttf',
            bold: 'arialbd.ttf',
            italics: 'ariali.ttf',
            bolditalics: 'arialbi.ttf'
        }
    };

    $(document).ready(function () {

        var table = $('table').DataTable({
            lengthChange: false,
            order: [[1, "asc"]],
            buttons: ['copy', 'excel',
                {
                    extend: 'print',

                }
                , 'colvis'],


            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        @if(isset($con))
                        columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 12]
                        @else
                        columns: ':visible:not(:last-child)'
                        @endif

                    },
                    customize: function (win) {
                        $(win.document.body)
                            .css('font-size', '10pt');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .attr('dir', 'rtl')
                            .css('font-size', '20px');
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        @if(isset($con))
                        columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 12]
                        @else
                        columns: ':visible:not(:last-child)'
                        @endif
                    }
                }, {
                    extend: 'colvis',
                },
                // {
                //     text: 'PDF',
                //     action: function (e, dt, node, config) {
                //         main_url = String(window.location.href) + '?pdf=true';
                //         window.location.replace(main_url);
                //
                //     }
                // },


            ]
        });

        table.buttons().container()
            .appendTo('#table_data .col-md-6:eq(0)');
    });
</script>
