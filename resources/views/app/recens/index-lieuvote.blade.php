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
        </style>
    </x-slot>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(auth()->user()->hasPermissionTo("can-open-section-only"))
                @php
                    $user = auth()->user();
                    $name = $user->name;
                    $prenom = $user->prenom;
                    $agent_Section = App\Models\AgentDeSection::where([
                      ["nom","like", $name],
                      ["prenom","like", $prenom],
                    ])->with("section")->first();
                @endphp
            Recensement au niveau des LV - Section: {{ optional($agent_Section->section)->libel ?? "-"}}
            @else
                @lang('crud.lieu_votes.index_title')
            @endif
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
                            </tr>
                                <th class="px-4 py-3 text-center">
                                    ID
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Régions
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Departements
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Communes
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Sections
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Lieux De Vote
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Parrainés
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Electorat
                                </th>
                                <th class="px-4 py-3 text-right">
                                    Objectif
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
        <script>
            $(function () {
                
                var table = $('#table1').DataTable({
                    dom: 'lfrtip',
                    info: true,
                    // orderCellsTop: true,
                    // fixedHeader: true,
                    // pageLength: 5,
                    lengthMenu: [[10, 20, 50, 100, 150, 250, -1], [10, 20, 50, 100, 150, 250, 'Tous']],
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
                                $(cell).html('<input id="input'+colIdx+'" type="text" placeholder="…" style="min-width: 40px;width: 100%;border: 1px solid #c1bdbd;border-radius: 7px; min-width: 80px;" />');
             
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
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('recens.lvotes.list', ['single'=>0]) }}",
                    "pagingType": 'full_numbers',
                    "deferRender": true,
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'regionm', name: 'regionm'},
                        {data: 'departm', name: 'departm'},
                        {data: 'communem', name: 'communem'},
                        {data: 'sectionm', name: 'sectionm'},
                        {data: 'libel', name: 'libel'},
                        {data: 'parrainm', name: 'parrainm'},
                        {data: 'electorm', name: 'electorm'},
                        {data: 'objectif', name: 'objectif'},
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
