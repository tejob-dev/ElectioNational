<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>Votime</title>
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        
        <!-- Icons -->
        <link rel="shortcut icon" href="/img/favicon.jpg" type="image/x-icon">
        <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
        
        <!-- Scripts -->
        <style>
            .button-primary.button {
              background-color: #026200!important;
            }
            .button.button-primary:hover {
              background-color: #026200!important;
            }
            
            body > div.min-h-screen.bg-gray-100 > main > div {
                background-color: #88730f;
            }
            
            body > div.min-h-screen.bg-gray-100 > main > div > div > div.rounded-lg.my-4 > div > div {
                margin: 0 12%!important;
                border: 1px solid white;
                background-color: #55c453;
            }
            
            body > div.min-h-screen.bg-gray-100 > header {
                background-color: #55c453 !important;
                border-bottom: 1px solid white;
            }
            
            body > div.min-h-screen.bg-gray-100 > nav {
                background-color: #55c453!important;
            }
            
            .rounded-md {
                background-color: #f0f1f3;
            }
            
            body > div.min-h-screen {
                background-color: #88730f;
            }
        </style>
        
        <script src="{{ mix('js/app.js') }}" defer></script>

        @if (isset($stylec))
            {{ $stylec }}
        @endif
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')
        
            <!-- Pabody > div.min-h-screen.bg-gray-100 > navge Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" style="display: flex;justify-content: space-between;">
                        {{ $header }}
                        <div class="font-semibold text-xl text-gray-800 leading-tight" style="display: block;width: fit-content;" id="dateContainer"></div>
                    </div>
                </header>
            @endif
        
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <div class="text-center fixed b-0" style="bottom: 0;left: 50%;transform: translateX(-50%);">
                <span class="text-center text-white">© 2016 - 2025 : ÉLECTIO | TKFAART Inc</span>
            </div>
        </div>

        @stack('modals')
        
        @livewireScripts
        
        @stack('scripts')
        
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        
        @if (session()->has('success')) 
        <script>
            var notyf = new Notyf({dismissible: true})
            notyf.success('{{ session('success') }}')
        </script> 
        @endif
        
        <script>
            /* Simple Alpine Image Viewer */
            document.addEventListener('alpine:init', () => {
                Alpine.data('imageViewer', (src = '') => {
                    return {
                        imageUrl: src,
        
                        refreshUrl() {
                            this.imageUrl = this.$el.getAttribute("image-url")
                        },
        
                        fileChosen(event) {
                            this.fileToDataUrl(event, src => this.imageUrl = src)
                        },
        
                        fileToDataUrl(event, callback) {
                            if (! event.target.files.length) return
        
                            let file = event.target.files[0],
                                reader = new FileReader()
        
                            reader.readAsDataURL(file)
                            reader.onload = e => callback(e.target.result)
                        },
                    }
                })
            })
        </script>
        
        @if (isset($scriptc))
            {{ $scriptc }}
        @endif
        <script>
            function updateDateTime() {
                // Get the current date and time
                const currentDate = new Date();
    
                // Define the days of the week in French
                const daysOfWeek = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    
                // Define the months in French
                const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    
                // Format the date as desired
                const formattedDate = `${daysOfWeek[currentDate.getDay()]} ${currentDate.getDate()} ${months[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
                
                // Format the time as desired (add leading zeros to hour and minute)
                const formattedTime = `${String(currentDate.getHours()).padStart(2, '0')}:${String(currentDate.getMinutes()).padStart(2, '0')}:${String(currentDate.getSeconds()).padStart(2, '0')}`;
    
                // Update the content on the page
                document.getElementById('dateContainer').innerText = formattedDate+" "+formattedTime;
                //document.getElementById('timeContainer').innerText = ;
            }
    
            // Update the date and time initially
            updateDateTime();
    
            // Update the date and time every second (1000 milliseconds)
            setInterval(updateDateTime, 1000);
        </script>
    </body>
</html>
