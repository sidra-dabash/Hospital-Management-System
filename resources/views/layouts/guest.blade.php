<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Vivio') }} - تسجيل الدخول</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-primary-50 via-white to-secondary-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <div class="absolute inset-0 opacity-20 pointer-events-none select-none">
                <div class="absolute top-10 right-10 text-[200px] text-primary-200">🏥</div>
                <div class="absolute bottom-10 left-10 text-[160px] text-secondary-200">💊</div>
            </div>

            <div class="relative z-10 w-full sm:max-w-xl mt-6 px-6 pt-16 pb-12 sm:pt-20 sm:pb-14 bg-white/90 backdrop-blur border border-primary-100 shadow-2xl rounded-3xl">

                <div class="flex justify-center mb-6">
                    <a href="{{ route('home') }}" class="flex flex-col items-center">
                        <img
                            src="{{ asset('images/vivio-logo.png') }}"
                            alt="Vivio"
                            class="h-20 w-auto object-contain mb-2"
                        >
                        <p class="text-neutral-500 font-bold text-sm">نظام Vivio لإدارة المشافي</p>
                    </a>
                </div>

                {{ $slot }}

                <div class="mt-8 text-center text-xs text-neutral-400 border-t border-neutral-100 pt-4">
                    جميع الحقوق محفوظة © {{ date('Y') }} Vivio Healthcare
                </div>
            </div>
        </div>
    </body>
</html>
