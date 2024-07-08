<x-app-layout>
    <x-slot name="stylec">
        <link rel="stylesheet" href="/cssc/bootstrap.min.css">
        <link rel="stylesheet" href="/cssc/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/cssc/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/cssc/buttons.bootstrap4.min.css">

        <style>
            a {
                text-decoration: none !important;
            }

            #table1_info,
            #table1_length,
            #table1_paginate,
            #table1_filter {
                display: inline-block;
                width: 50%;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #fff;
                text-align: center;
                padding: 10px;
            }

            #table1 > thead > tr:nth-child(2) > th:nth-child(1), #table1 > thead > tr:nth-child(2) > th:nth-child(2) {
                border-top: none;
            }

            tbody tr:last-child td {
                background-color: red!important;
                color: white!important;
            }

            .header-main {
                background-color: #D8BFD8!important;
                color: #000;
            }
            #table1 > tbody > tr > td:nth-child(6) {
                background-color: #D8BFD8;
                color: #000;
            }

            #table1 > tbody > tr > td:nth-child(4) {
                background-color: #98FB98;
            }
            
            .sub-header {
                background-color: #98FB98!important;
            }
            
            #table1 > tbody > tr > td:nth-child(3), #table1 > tbody > tr > td:nth-child(5) {
                background-color: #98FB98;
            }

            .sub-header-orange {
                background-color: #FFDAB9!important;
            }
            
            #table1 > tbody > tr > td:nth-child(4) {
                background-color: #FFDAB9;
            }

            .sub-header-purple {
                background-color: #D8BFD8!important;
            }

            .main-header  {
                background-color: #228B22!important;
                color: #fff;
            }
            
            /*#table1 > tbody > tr > td:nth-child(1), #table1 > tbody > tr > td:nth-child(2),*/
             #table1 > tbody > tr > td:nth-child(8)  {
                background-color: #228B22;
                color: #fff;
            }

            .header-secondary {
                background-color: #ADD8E6!important;
                color: #000;
            }
            
            #table1 > tbody > tr > td:nth-child(7) {
                background-color: #ADD8E6;
                color: #000;
            }

            .sub-header-blue{
                background-color: #ADD8E6!important;
            }

            .sub-header-green {
                background-color: #008000!important;
                color: #fff;
            }

            .sub-header-yellow {
                background-color: #FFFF00!important;
            }
            
            #table1 > tbody > tr > td:nth-child(10), #table1 > tbody > tr > td:nth-child(9) {
                background-color: #FFFF00;
            }

            .sub-header-grey {
                background-color: #D3D3D3!important;
            }
            
            #table1 > tbody > tr > td:nth-child(11), #table1 > tbody > tr > td:nth-child(12) {
                background-color: #D3D3D3;
            }

            .sub-header-pink {
                background-color: #FFB6C1!important;
            }
            
            #table1 > tbody > tr > td:nth-child(13) {
                background-color: #FFB6C1;
            }

            input{
                color: #000;
            }

            
        </style>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Recensement - Régions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">

                        </div>
                        <div class="md:w-1/2 text-right flex justify-end">

                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-auto scrolling-touch">
                    <table id="table1" class="table table-borderless table-hover">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="" rowspan="1"></th>
                                <th class="" rowspan="1"></th>
                                <th class="header-main" colspan="4">OBJECTIFS DE RECENSEMENT</th>
                                <th class="header-secondary" colspan="8">DONNÉES DE RECENSEMENT</th>
                            </tr>
                            <tr>
                                <th class="" rowspan="1">DISTRICTS</th>
                                <th class="" rowspan="1">REGIONS</th>
                                <th class="sub-header">RGPH 2021</th>
                                <th class="sub-header-orange">ATTENTE 45% RGPH</th>
                                <th class="sub-header">INSCRITS LISTE CEI 2023</th>
                                <th class="sub-header-purple">OBJECTIFS</th>
                                <th class="sub-header-blue">TOTAL RECENSÉS</th>
                                <th class="sub-header-green">ELECTORAT 2023</th>
                                <th class="sub-header-yellow">RECENSÉS AVEC CNI</th>
                                <th class="sub-header-yellow">RECENSÉS SANS CNI</th>
                                <th class="sub-header-grey">RECENSÉS AVEC EXTRAIT</th>
                                <th class="sub-header-grey">RECENSÉS SANS EXTRAIT</th>
                                <th class="sub-header-pink">RESTE À RECENSER</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-center">

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>

    <x-slot name="scriptc">
        <script src="/jsc/jquery.min.js"></script>
        <script src="/jsc/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="/jsc/jquery.dataTables.min.js"></script>
        <script src="/jsc/dataTables.bootstrap4.min.js"></script>
        <script src="/jsc/dataTables.responsive.min.js"></script>
        <script src="/jsc/responsive.bootstrap4.min.js"></script>
        <script src="/jsc/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
        <script src="/jsc/buttons.bootstrap4.min.js"></script>
        <script src="/jsc/jszip.min.js"></script>
        <script src="/jsc/pdfmake.min.js"></script>
        <script src="/jsc/vfs_fonts.js"></script>
        <script src="/jsc/buttons.html5.min.js"></script>
        <script src="/jsc/buttons.print.min.js"></script>
        <script src="/jsc/buttons.colVis.min.js"></script>
        <script>
            $(function() {

                var table = $('#table1').DataTable({
                    dom: 'lfrtip',
                    info: true,
                    // orderCellsTop: true,
                    // fixedHeader: true,
                    // pageLength: 5,
                    lengthMenu: [
                        [10, 20, 50, 100, 150, 250, -1],
                        [10, 20, 50, 100, 150, 250, 'Tous']
                    ],
                    initComplete: function () {
                        $('table > thead:nth-child(1) > tr:last-child')
                        .clone(true)
                        .addClass('filters')
                        .appendTo('table > thead:nth-child(1)');
                        
                        var api = this.api();
            
                        // For each column
                        api
                            .columns()
                            .eq(0)
                            .each(function (colIdx) {
                                // Set the header cell to contain the input element
                                var cell = $('.filters th').eq(
                                    $(api.column(colIdx).header()).index()
                                );
                                var title = $(cell).text();
                                if([0, 1].includes(colIdx)){
                                    $(cell).html('<input id="input'+colIdx+'" type="text" placeholder="…" style="min-width: 40px;width: 100%;border: 1px solid #c1bdbd;border-radius: 7px; min-width: 80px;" />');
                                }else{
                                    $(cell).html('');
                                }
             
                                // On every keypress in this input
                                $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                    .off('keyup change')
                                    .on('change', function (e) {
                                        // Get the search value
                                        $(this).attr('title', $(this).val());
                                        var regexr = '({search})'; //$(this).parents('th').find('select').val();
             
                                        var cursorPosition = this.selectionStart;
                                        // Search the column for that value
                                        api
                                            .column(colIdx)
                                            .search(
                                                this.value != ''
                                                    ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                    : '',
                                                this.value != '',
                                                this.value == ''
                                            )
                                            .draw();
                                    })
                                    .on('keyup', function (e) {
                                        e.stopPropagation();
             
                                        $(this).trigger('change');
                                        $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                    });
                            });
                    },
                    drawCallback: function( settings ) {
                        var api = this.api();
                        // Output the data for the visible rows to the browser's console
                        var listOfSum = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
                        api
                        .rows()
                        .every(function() {
                            var rowData = this.data();
                            // rowData is an array containing the values of each column for the current row

                            // Example: Accessing value of the first column (index 0)
                            //var column1Value = rowData[0];
                            // Example: Accessing value of the second column (index 1)
                            listOfSum[0] += parseInt(rowData.rgph);
                            listOfSum[1] += parseInt(rowData.rgphattente);
                            listOfSum[2] += parseInt(rowData.inscritcei);
                            listOfSum[3] += parseInt(rowData.objectif);
                            listOfSum[4] += parseInt(rowData.recenses);
                            listOfSum[5] += parseInt(rowData.electorat);
                            listOfSum[6] += parseInt(rowData.recensescni);
                            listOfSum[7] += parseInt(rowData.recensesncni);
                            listOfSum[8] += parseInt(rowData.recensesextr);
                            listOfSum[9] += parseInt(rowData.recensesnextr);
                            listOfSum[10] += parseInt(rowData.restrecenses);
                            // listOfSum[12] += parseInt(rowData.candidatf);
                            // listOfSum[13] += parseInt(rowData.candidatg);
                            // listOfSum[14] += parseInt(rowData.candidath);
                            //console.log(rowData);
                            //var columnNameValue = this.column('column_name').data()[0];
                            //console.log('Value of column "column_name" for this row:', columnNameValue);
                        });
                        $('<tr><td class="sorting_1">TOTAL GENERALE</td><td></td><td>'+listOfSum[0]+'</td><td>'+listOfSum[1]+'</td><td>'+listOfSum[2]+'</td><td>'+listOfSum[3]+'</td><td>'+listOfSum[4]+'</td><td>'+listOfSum[5]+'</td><td>'+listOfSum[6]+'</td><td>'+listOfSum[7]+'</td><td>'+listOfSum[8]+'</td><td>'+listOfSum[9]+'</td><td>'+listOfSum[10]+'</td></tr>')
                        .insertAfter($('table > tbody tr:last-child()'));
                        //console.log(listOfSum);
                        console.log("list of sum");
                    },
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('recens.regions.list', ['single'=>0]) }}",
                    "pagingType": 'full_numbers',
                    "deferRender": true,
                    columns: [
                        {data: 'districts', name: 'districts'},
                        {data: 'regions', name: 'regions'},
                        {data: 'rgph', name: 'rgph'},
                        {data: 'rgphattente', name: 'rgphattente'},
                        {data: 'inscritcei', name: 'inscritcei'},
                        {data: 'objectif', name: 'objectif'},
                        {data: 'recenses', name: 'recenses'},
                        {data: 'electorat', name: 'electorat'},
                        {data: 'recensescni', name: 'recensescni'},
                        {data: 'recensesncni', name: 'recensesncni'},
                        {data: 'recensesextr', name: 'recensesextr'},
                        {data: 'recensesnextr', name: 'recensesnextr'},
                        {data: 'restrecenses', name: 'restrecenses'},
                        // {
                        //     data: 'id',
                        //     name: 'id'
                        // },
                        // {data: 'departm', name: 'departm'},
                        // {data: 'communem', name: 'communem'},
                        // {data: 'sectionm', name: 'sectionm'},
                        // {data: 'libel', name: 'libel'},
                        // {data: 'parrainm', name: 'parrainm'},
                        // {data: 'electorm', name: 'electorm'},
                        // {data: 'objectif', name: 'objectif'},
                    ],
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
                    },
                    buttons: [],
                    searching: true,
                    order: [
                        [0, 'desc']
                    ],
                    // responsive: true,
                }).buttons().container().enable();

            });
        </script>
    </x-slot>
</x-app-layout>