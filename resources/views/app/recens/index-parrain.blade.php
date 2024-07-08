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
            Recensement des parrains - Section: {{ optional($agent_Section->section)->libel ?? "-"}}
            @else
            @lang('crud.parrains.index_title')
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
                            @if(!auth()->user()->hasRole('Invité de section'))
                            <a
                                href="{{ route('parrains.export') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-paper"></i>
                                Tous exportés
                            </a>
                            <a
                                href="#actio"
                                onclick="exportSelectParrain()"
                                class="button button-primary mx-2"
                            >
                                <i class="mr-1 icon ion-md-paper"></i>
                                Exporter les parrainés affichés
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-auto scrolling-touch">
                    <table id="table1" class="table table-borderless table-hover">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-center">
                                    ID
                                </th>
                                <th class="px-4 py-3 text-left">
                                Districts
                                </th>
                                <th class="px-4 py-3 text-left">
                                Régions
                                </th>
                                <th class="px-4 py-3 text-left">
                                Départements
                                </th>
                                <th class="px-4 py-3 text-left">
                                Communes
                                </th>
                                <th class="px-4 py-3 text-center">
                                    Parrain
                                </th>
                                <th class="px-4 py-3">
                                    Profil du parrain
                                </th>
                                <th class="px-4 py-3">
                                    Tel.&nbsp;Parrain
                                </th>
                                <th class="px-4 py-3">
                                    Recenseur
                                </th>
                                <th class="px-4 py-3 ">
                                    Nom
                                </th>
                                <th class="px-4 py-3 ">
                                    Prenoms
                                </th>
                                <th class="px-4 py-3 ">
                                    Date de naissance
                                </th>
                                <th class="px-4 py-3 ">
                                    Tel.
                                </th>
                                <th class="px-4 py-3 ">
                                    Liste électorale
                                </th>
                                <th class="px-4 py-3 ">
                                    Militant ou Sympatisant
                                </th>
                                <th class="px-4 py-3 ">
                                    Une carte CNI
                                </th>
                                <th class="px-4 py-3 ">
                                    Extrait
                                </th>
                                <!-- <th class="px-4 py-3">
                                    Tel. Parrain/Marraine
                                </th> -->
                                <th class="px-4 py-3">
                                    Profession
                                </th>
                                <th class="px-4 py-3">
                                    Observation
                                </th>
                                <th class="px-4 py-3">
                                    Recensé le
                                </th>
                                <th class="px-4 py-3">
                                    Statut
                                </th>
                                <th class="px-4 py-3">
                                    Photo
                                </th>
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

        <script src="{{asset('imagefade/js_KBmodal.js')}}"></script>

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
                        $('#table1 thead tr')
                        .clone(true)
                        .addClass('filters')
                        .appendTo('#table1 thead');
                        
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
                                if(colIdx != "8" && colIdx != "16" && colIdx != "19" ) $(cell).html('<input id="input'+colIdx+'" type="text" placeholder="…" style="min-width: 40px;width: 100%;border: 1px solid #c1bdbd;border-radius: 7px; min-width: 80px;" />');
                                else $(cell).html('');
             
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
                    ajax: "{{ route('recens.parrains.list', ['single'=>0]) }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'district', name: 'district'},
                        {data: 'region', name: 'region'},
                        {data: 'departement', name: 'departement'},
                        {data: 'commune', name: 'commune'},
                        {data: 'agent', name: 'agent'},
                        {data: 'profil', name: 'profil'},
                        {data: 'telephoneag', name: 'telephoneag'},
                        {data: 'recenser', name: 'recenser'},
                        // {data: 'section', name: 'section'},
                        // {data: 'soussection', name: 'soussection'},
                        {data: 'nom', name: 'nom'},
                        {data: 'prenom', name: 'prenom'},
                        {data: 'date_naissp', name: 'date_naissp'},
                        {data: 'telephone', name: 'telephone'},
                        {data: 'list_elect', name: 'list_elect'},
                        {data: 'is_milit', name: 'is_milit'},
                        // {data: 'codelv', name: 'codelv'},
                        {data: 'cni_dispo', name: 'cni_dispo'},
                        {data: 'extrait', name: 'extrait'},
                        // {data: 'telparrain', name: 'telparrain'},
                        // {data: 'cart_elect', name: 'cart_elect'},
                        // {data: 'residence', name: 'residence'},
                        {data: 'profession', name: 'profession'},
                        {data: 'observation', name: 'observation'},
                        {data: 'createdat', name: 'createdat'},
                        {data: 'status', name: 'status'},
                        {data: 'pphoto', name: 'pphoto'},
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
        
        <script type="text/javascript">
            function exportSelectParrain(){
                
                var ids = "";
                document.querySelectorAll('#table1 > tbody > tr td:nth-child(1)').forEach( item => { ids += item.textContent+"," } ); 
                ids = ids.substring(0,ids.length-1);
                
                window.location.href = "/export/parrain/only/?ids="+ids;
            }
        </script>
    </x-slot>
</x-app-layout>