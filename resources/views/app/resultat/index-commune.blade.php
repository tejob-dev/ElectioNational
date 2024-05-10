<x-app-layout>
    <x-slot name="stylec">
        <link rel="stylesheet" href="/cssc/bootstrap.min.css">
        <link rel="stylesheet" href="/cssc/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/cssc/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/cssc/buttons.bootstrap4.min.css">
        
        <style>
            a{
                text-decoration: none!important;
            }
            
            #table1_info, #table1_length, #table1_paginate, #table1_filter{
                    display: inline-block;
                    width: 50%;
            }

            tbody tr:nth-child(1) {
            background-color: #cdcdcd;
            color:black
            }

            tbody tr:nth-child(1) td:nth-child(9){
             color:red;
            }
            
            div.img-wrapper {
                width: 41px!important;
            }
        </style>
    </x-slot>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Résultat du scrutin - Region
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
                                    Régions
                                </th>
                                <th class="px-4 py-3 text-center">
                                    LV
                                </th>
                                <th class="px-4 py-3 text-center">
                                    BV
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
                                    Suff.
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
            $(function () {
                
                var table = $('#table1').DataTable({
                    dom: 'lfrtip',
                    info: true,
                    // orderCellsTop: true,
                    // fixedHeader: true,
                    // pageLength: 5,
                    // lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Tous']],
                    //initComplete: function () {
                    //     $('table > thead:nth-child(1) > tr')
                    //     .clone(true)
                    //     .addClass('filters')
                    //     .appendTo('table > thead:nth-child(1)');
                        
                    //     var api = this.api();
            
                    //     // For each column
                    //     api
                    //         .columns()
                    //         .eq(0)
                    //         .each(function (colIdx) {
                    //             // Set the header cell to contain the input element
                    //             var cell = $('.filters th').eq(
                    //                 $(api.column(colIdx).header()).index()
                    //             );
                    //             var title = $(cell).text();
                    //             $(cell).html('<input id="input'+colIdx+'" type="text" placeholder="…" style="min-width: 40px;width: 100%;border: 1px solid #c1bdbd;border-radius: 7px; min-width: 80px;" />');
             
                    //             // On every keypress in this input
                    //             $(
                    //                 'input',
                    //                 $('.filters th').eq($(api.column(colIdx).header()).index())
                    //             )
                    //                 .off('keyup change')
                    //                 .on('change', function (e) {
                    //                     // Get the search value
                    //                     $(this).attr('title', $(this).val());
                    //                     var regexr = '({search})'; //$(this).parents('th').find('select').val();
             
                    //                     var cursorPosition = this.selectionStart;
                    //                     // Search the column for that value
                    //                     api
                    //                         .column(colIdx)
                    //                         .search(
                    //                             this.value != ''
                    //                                 ? regexr.replace('{search}', '(((' + this.value + ')))')
                    //                                 : '',
                    //                             this.value != '',
                    //                             this.value == ''
                    //                         )
                    //                         .draw();
                    //                 })
                    //                 .on('keyup', function (e) {
                    //                     e.stopPropagation();
             
                    //                     $(this).trigger('change');
                    //                     $(this)
                    //                         .focus()[0]
                    //                         .setSelectionRange(cursorPosition, cursorPosition);
                    //                 });
                    //         });
                    // },
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('resultats.communes.list', ['single'=>0]) }}",
                    columns: [
                        {data: 'circonscription', name: 'circonscription'},
                        {data: 'lieuvote', name: 'lieuvote'},
                        {data: 'bureauvote', name: 'bureauvote'},
                        {data: 'nbrinscrit', name: 'nbrinscrit'},
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
                    ],
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json',
                    },
                    buttons: [],
                    //searching: true,
                    order: [[0, 'asc']],
                    // responsive: true,
                }).buttons().container().enable();
                
              });
        </script>
    </x-slot>
</x-app-layout>
