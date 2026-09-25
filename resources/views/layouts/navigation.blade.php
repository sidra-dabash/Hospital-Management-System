@php
    $user = auth()->user();
    $isAdmin = $user?->hasRole('admin');
    $isDoctor = $user?->hasRole('doctor');
    $isNurse = $user?->hasRole('nurse');
    $isReceptionist = $user?->hasRole('receptionist');
    $isAccountant = $user?->hasRole('accountant');
    $isPatient = $user?->hasRole('patient');

    $navItems = [];

    if ($isPatient) {
        $navItems = [
            ['name' => 'الرئيسية', 'route' => 'dashboard'],
            ['name' => 'مواعيدي', 'route' => 'appointments.index'],
            ['name' => 'فواتيري', 'route' => 'bills.index'],
            ['name' => 'الملف الشخصي', 'route' => 'profile.edit'],
        ];
    } elseif ($isDoctor) {
        $navItems = [
            ['name' => 'الرئيسية', 'route' => 'dashboard'],
            ['name' => 'مواعيدي', 'route' => 'appointments.index'],
            ['name' => 'مرضاي', 'route' => 'patients.index'],
            ['name' => 'الملف الشخصي', 'route' => 'profile.edit'],
        ];
    } elseif ($isNurse) {
        $navItems = [
            ['name' => 'الرئيسية', 'route' => 'dashboard'],
            ['name' => 'المواعيد', 'route' => 'appointments.index'],
            ['name' => 'المرضى', 'route' => 'patients.index'],
            ['name' => 'الملف الشخصي', 'route' => 'profile.edit'],
        ];
    } elseif ($isReceptionist) {
        $navItems = [
            ['name' => 'الرئيسية', 'route' => 'dashboard'],
            ['name' => 'المرضى', 'route' => 'patients.index'],
            ['name' => 'المواعيد', 'route' => 'appointments.index'],
            ['name' => 'الأطباء', 'route' => 'doctors.index'],
            ['name' => 'الملف الشخصي', 'route' => 'profile.edit'],
        ];
    } elseif ($isAccountant) {
        $navItems = [
            ['name' => 'الرئيسية', 'route' => 'dashboard'],
            ['name' => 'التقارير', 'route' => 'reports.index'],
            ['name' => 'الفواتير', 'route' => 'bills.index'],
            ['name' => 'الملف الشخصي', 'route' => 'profile.edit'],
        ];
    } elseif ($isAdmin) {
        $navItems = [
            ['name' => 'الرئيسية', 'route' => 'dashboard'],
            ['name' => 'المرضى', 'route' => 'patients.index'],
            ['name' => 'الأطباء', 'route' => 'doctors.index'],
            ['name' => 'المواعيد', 'route' => 'appointments.index'],
            ['name' => 'الفواتير', 'route' => 'bills.index'],
            ['name' => 'الأقسام', 'route' => 'departments.index'],
            ['name' => 'التقارير', 'route' => 'reports.index'],
            ['name' => 'الملف الشخصي', 'route' => 'profile.edit'],
        ];
    } else {
        $navItems = [
            ['name' => 'الرئيسية', 'route' => 'dashboard'],
            ['name' => 'الملف الشخصي', 'route' => 'profile.edit'],
        ];
    }

    $roleLabel = match(true) {
        $isAdmin => 'مدير النظام',
        $isDoctor => 'طبيب',
        $isNurse => 'ممرض',
        $isReceptionist => 'موظف استقبال',
        $isAccountant => 'محاسب',
        $isPatient => 'مريض',
        default => 'مستخدم',
    };
@endphp

<nav x-data="{ mobileMenu: false, userMenu: false }"
     class="bg-white border-b border-neutral-100 sticky top-0 z-40 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center h-20">

            <div class="flex items-center shrink-0">

                <a href="{{ route('dashboard') }}"
                   class="flex items-center">

                    <img
                        src="{{ asset('images/vivio-logo.png') }}"
                        alt="Vivio"
                        class="h-16 w-auto object-contain"
                        style="max-width: 210px;"
                    >

                </a>

            </div>

            <div class="hidden lg:flex min-w-0 flex-1 items-center justify-center gap-1 overflow-x-auto scrollbar-thin">

                @foreach($navItems as $item)

                    @php
                        $isActive = false;
                        $routeName = $item['route'] ?? null;

                        if (($item['active'] ?? true) && $routeName && request()->routeIs($routeName)) {
                            $isActive = true;
                        } elseif (($item['active'] ?? true) && 
                            $routeName === 'reports.index' && request()->routeIs('reports.*')
                        ) {
                            $isActive = true;
                        } elseif (($item['active'] ?? true) && 
                            $routeName === 'patients.index' && request()->routeIs('patients.*')
                        ) {
                            $isActive = true;
                        } elseif (($item['active'] ?? true) && 
                            $routeName === 'doctors.index' && request()->routeIs('doctors.*')
                        ) {
                            $isActive = true;
                        } elseif (($item['active'] ?? true) && 
                            $routeName === 'departments.index' && request()->routeIs('departments.*')
                        ) {
                            $isActive = true;
                        } elseif (($item['active'] ?? true) && 
                            $routeName === 'appointments.index' && request()->routeIs('appointments.*')
                        ) {
                            $isActive = true;
                        }

                        $itemUrl = $item['href'] ?? route($routeName);
                    @endphp

                    <a href="{{ $itemUrl }}"
                       class="nav-link shrink-0 whitespace-nowrap {{ $isActive ? 'nav-link-active' : '' }}">
                        @if(!empty($item['icon']))<span class="ms-1">{{ $item['icon'] }}</span>@endif
                        <span class="text-sm font-semibold">
                            {{ $item['name'] }}
                        </span>
                    </a>

                @endforeach

            </div>

            <div class="hidden lg:flex items-center gap-3 shrink-0">

                <button
                    class="relative p-2 rounded-xl hover:bg-neutral-100 transition-colors">

                    <svg
                        class="w-6 h-6 text-neutral-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                        />

                    </svg>

                    <span
                        class="absolute top-1 left-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white">
                    </span>

                </button>

                <div class="flex items-center gap-3 pe-4 border-e border-neutral-200">

                    <div class="text-end">
                        <div class="font-bold text-neutral-800 text-sm">
                            {{ auth()->user()->name }}
                        </div>
                        <div class="text-xs text-neutral-500">
                            {{ $roleLabel }}
                        </div>

                    </div>

                    <div
                        class="w-11 h-11 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-bold border-2 border-white shadow-md">

                        {{ mb_substr(auth()->user()->name, 0, 1) }}

                    </div>

                </div>

                <div class="relative">

                    <button
                        @click="userMenu = ! userMenu"
                        class="p-2 rounded-xl hover:bg-neutral-100 transition-colors">

                    <svg
                        class="w-5 h-5 text-neutral-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />

                        </svg>
                    </button>

                    <div
                        x-show="userMenu"
                        x-transition
                        x-cloak
                        class="absolute end-0 top-full mt-2 w-48 bg-white rounded-2xl shadow-card border border-neutral-100 py-2 z-50"
                        @click.outside="userMenu = false">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="block px-4 py-2.5 text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                            👤 الملف الشخصي
                        </a>

                        <hr class="my-1 border-neutral-100" />

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <a
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50">
                                🚪 تسجيل الخروج
                            </a>

                        </form>

                    </div>

                </div>

            </div>

            <div class="lg:hidden -me-2 flex items-center">

                <button
                    @click="mobileMenu = ! mobileMenu"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition duration-150 ease-in-out">

                    <svg
                        class="h-7 w-7"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24">

                        <path
                            :class="{'hidden': mobileMenu, 'inline-flex': ! mobileMenu }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />

                        <path
                            :class="{'hidden': ! mobileMenu, 'inline-flex': mobileMenu }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />

                    </svg>

                </button>

            </div>

        </div>

    </div>

    <div
        :class="{'block': mobileMenu, 'hidden': ! mobileMenu}"
        class="hidden lg:hidden border-t border-neutral-200">

        <div class="pt-3 pb-4 space-y-1 px-4">

            @foreach($navItems as $item)

                <a
                    href="{{ $item['href'] ?? route($item['route']) }}"
                    class="block px-4 py-3 rounded-xl text-base font-medium text-neutral-700 hover:bg-primary-50 hover:text-primary-700 transition">
                    @if(!empty($item['icon']))<span class="ml-2">{{ $item['icon'] }}</span>@endif
                    {{ $item['name'] }}
                </a>

            @endforeach

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="mt-3 pt-4 border-t border-neutral-200">

                @csrf

                <a
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();"
                    class="block w-full text-right px-4 py-3 rounded-xl text-base font-medium text-red-600 hover:bg-red-50 transition">
                    🚪 تسجيل الخروج
                </a>

            </form>

            <div class="flex items-center gap-3 px-4 py-2 bg-neutral-50 rounded-xl mt-3">

                <div
                    class="w-11 h-11 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-bold">

                    {{ mb_substr(auth()->user()->name, 0, 1) }}

                </div>

                <div>

                    <div class="font-bold text-neutral-800">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="text-sm text-neutral-500">
                        {{ $roleLabel }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</nav>
