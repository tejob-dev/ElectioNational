<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
        
        <!-- Icons -->
        <link rel="shortcut icon" href="/img/favicon.jpg" type="image/x-icon">
        <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
        
        <style>
            .w-full.sm\:max-w-md.mt-6.px-6.py-4.bg-white.shadow-md.overflow-hidden.sm\:rounded-lg {
              background-color: #b39400;
              box-shadow: 10px 2px 50px #88730f;
            }
            #email, #password {
              background: #1d8a4b;
              border: 2px solid white;
              color: white !important;
            }
            #email::placeholder, #password::placeholder {
              color: white !important;
            }
            .inline-flex.items-center.px-4.py-2.bg-gray-800.border.border-transparent.rounded-md.font-semibold.text-xs.text-white.uppercase.tracking-widest.hover\:bg-gray-700.active\:bg-gray-900.focus\:outline-none.focus\:border-gray-900.focus\:ring.focus\:ring-gray-300.disabled\:opacity-25.transition.ml-4 {
              background-color: #295ba6;
            }
            label.flex {
              background-color: #0000ff36;
            }
            #remember_me {
                color: #646c9d;
            }

            body > div.font-sans.text-gray-900.antialiased > div > div.w-full.sm\:max-w-md.mt-6.px-6.py-4.bg-white.shadow-md.overflow-hidden.sm\:rounded-lg > form > div.flex.items-center.justify-end.mt-4 > button {
                background-color: #1d8a4b!important;
            }
        </style>
        
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
        <div class="text-center fixed b-0" style="bottom: 0;left: 50%;transform: translateX(-50%);">
            <span class="text-center text-1 text-white" style="font-size:9px;">© 2016 - 2025 : ÉLECTIO | TKFAART Inc</span>
        </div>
    </body>
</html>
