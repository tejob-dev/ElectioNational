<x-app-layout>
    <x-slot name="stylec">
        <link rel="stylesheet" href="/cssc/bootstrap.min.css">
        <link rel="stylesheet" href="/cssc/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/cssc/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/cssc/buttons.bootstrap4.min.css">
        
        <link rel="stylesheet" href="{{asset('imagefade/css_KBmodal.css')}}">
        
        <style>
            a{
                text-decoration: none!important;
            }
            
            #table1_info, #table1_length, #table1_paginate, #table1_filter{
                    display: inline-block;
                    width: 50%;
            }

            tbody tr:nth-child(2n + 1) {
                background-color: #cdcdcd;
            }
            
            tbody tr {
                color:black
            }
            
            div.img-wrapper {
                width: 41px!important;
            }


            tbody tr td:nth-child(7){
                color:red;
            }

            tbody tr:last-child td:not(:first-child, :nth-child(2), :last-child) {
                background-color: red;
                color: white;
            }
        </style>
    </x-slot>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Résultats du scrutin - Bureau de Vote
        </h2>
    </x-slot>
    @php
        $candidats = App\Models\Candidat::get();
    @endphp
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
                            </tr>
                                <th class="px-4 py-3 text-center" style="min-width:18vw">
                                    Nom du LV
                                </th>
                                <th class="px-4 py-3 text-center" style="min-width:18vw">
                                    Bureau de Vote
                                </th>
                                <th class="px-4 py-3 text-center">
                                    Inscrits
                                </th>
                                <th class="px-4 py-3 text-center">
                                    Votants
                                </th>
                                <th class="px-4 py-3 text-center">
                                    Nuls
                                </th>
                                <th class="px-4 py-3 text-center">
                                    Blancs
                                </th>
                                <th class="px-4 py-3 text-center" style="background-color:#ffff99">
                                    Suffrage
                                </th>
                                <th class="px-4 py-3 text-center">
                                    Taux
                                </th>
                                @foreach ($candidats as $candidat)
                                    <th class="px-4 py-3 text-center">
                                        <div style="display:flex; flex-direction:column; align-items:center;" class="img-wrapper">
                                            <img src="{{  $candidat->photo ? \Storage::url($candidat->photo) : '' }}" alt="Candidat {{$candidat->nom}}" class="my-2 rounded-full" style="padding:3px;background-color:{{$candidat->couleur}};width:40px;">
                                            <p style="font-size:8px;margin: 0;" >{{ str_replace("-", "_", str_replace(" ", "_", $candidat->parti) ) }}</p>
                                        </div>
                                    </th>
                                @endforeach
                                <th class="px-4 py-3 text-center" style="font-weight: bold">
                                    PV
                                </th>
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
        
        <script src="{{asset('imagefade/js_KBmodal.js')}}"></script>

        <script>
            $(function () {
                
                var table = $('#table1').DataTable({
                    dom: 'lfrtip',
                    info: true,
                    // orderCellsTop: true,
                    // fixedHeader: true,
                    pageLength: 5,
                    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Tous']],
                    initComplete: function () {
                        $('table > thead:nth-child(1) > tr')
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
                                if(colIdx < 8) $(cell).html('<input id="input'+colIdx+'" type="text" placeholder="…" style="min-width: 40px;width: 100%;border: 1px solid #c1bdbd;border-radius: 7px; min-width: 80px;" />');
                                else{ 
                                    $(cell).html('');
                                    //$(cell).first().before( "" ).after("");
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
                                        /* try{
                                            $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                        }catch(e){
                                            console.log(e);
                                        } */
                                    });
                            });

                    },
                    drawCallback: function( settings ) {
                        var api = this.api();
                        // Output the data for the visible rows to the browser's console
                        var listOfSum = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
                        api
                        .rows()
                        .every(function() {
                            var rowData = this.data();
                            // rowData is an array containing the values of each column for the current row

                            // Example: Accessing value of the first column (index 0)
                            //var column1Value = rowData[0];
                            // Example: Accessing value of the second column (index 1)
                            
                            listOfSum[0] += parseInt(rowData.objectif);
                            listOfSum[1] += parseInt(rowData.votant);
                            listOfSum[2] += parseInt(rowData.bulnul);
                            listOfSum[3] += parseInt(rowData.bulblanc);
                            listOfSum[4] += parseInt(rowData.suffrage);
                            listOfSum[5] += parseInt(rowData.participation);
                            listOfSum[6] += parseInt(rowData.candidata);
                            listOfSum[7] += parseInt(rowData.candidatb);
                            listOfSum[8] += parseInt(rowData.candidatc);
                            listOfSum[9] += parseInt(rowData.candidatd);
                            listOfSum[10] += parseInt(rowData.candidate);
                            // listOfSum[11] += parseInt(rowData.candidatf);
                            // listOfSum[12] += parseInt(rowData.candidatg);
                            // listOfSum[13] += parseInt(rowData.candidath);
                            //console.log(rowData);
                            //var columnNameValue = this.column('column_name').data()[0];
                            //console.log('Value of column "column_name" for this row:', columnNameValue);
                        });
                        $('<tr><td><td></td><td>'+listOfSum[0]+'</td><td>'+listOfSum[1]+'</td><td>'+listOfSum[2]+'</td><td>'+listOfSum[3]+'</td><td>'+listOfSum[4]+'</td><td>'+Number( (((listOfSum[4]/listOfSum[0])*100).toFixed(3)) ).toFixed(2)+'%</td><td>'+listOfSum[6]+'</td><td>'+listOfSum[7]+'</td><td>'+listOfSum[8]+'</td><td>'+listOfSum[9]+'</td><td>'+listOfSum[10]+'</td><td></tr>') //+listOfSum[11]+'</td><td>'+listOfSum[12]+'</td><td>'+listOfSum[13]+'</td><td></td>
                        .insertAfter($('table > tbody tr:last-child()'));
                        //console.log(listOfSum);
                        console.log("list of sum");
                    },
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('resultats.bureauvotes.list', ['single'=>0]) }}",
                    columns: [
                        {data: 'lieuv', name: 'lieuv'},
                        {data: 'libel', name: 'libel'},
                        {data: 'objectif', name: 'objectif'},
                        {data: 'votant', name: 'votant'},
                        {data: 'bulnul', name: 'bulnul'},
                        {data: 'bulblanc', name: 'bulblanc'},
                        {data: 'suffrage', name: 'suffrage'},
                        {data: 'participation', name: 'participation'},
                        {data: 'candidata', name: 'candidata'},
                        {data: 'candidatb', name: 'candidatb'},
                        {data: 'candidatc', name: 'candidatc'},
                        {data: 'candidatd', name: 'candidatd'},
                        {data: 'candidate', name: 'candidate'},
                        // {data: 'candidatf', name: 'candidatf'},
                        // {data: 'candidatg', name: 'candidatg'},
                        // {data: 'candidath', name: 'candidath'},
                        {data: 'pverb', name: 'pverb'},
                    ],
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
                    },
                    buttons: [],
                    searching: true,
                    order: [[0, 'desc']],
                    // responsive: true,
                }).buttons().container().enable();
                
              });
        </script>
    </x-slot>
</x-app-layout>
