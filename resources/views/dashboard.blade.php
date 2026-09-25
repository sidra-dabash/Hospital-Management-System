<x-app-layout>
    @if(auth()->user()->hasRole('admin'))
        <section class="relative overflow-hidden bg-cover bg-center min-h-[410px]" style="background-image: url('{{ asset('images/nav.png') }}');">
            <div class="absolute inset-0 bg-white/20"></div>
            <div class="relative max-w-7xl mx-auto px-5 sm:px-8 py-20 text-right">
                <div class="max-w-xl mr-auto">
                    <p class="text-secondary-700 font-black text-lg mb-3">نظام Vivio لإدارة المشافي</p>
                    <h1 class="text-4xl sm:text-5xl font-black leading-tight text-primary-950">نظام إدارة<br><span class="text-secondary-600">المشفى الإلكتروني</span></h1>
                    <p class="text-primary-800 text-lg mt-5 leading-relaxed">إدارة سهلة لعمليات المشفى الأساسية.<br>ببساطة .. لراحة أفضل للمرضى والفريق الطبي.</p>
                    <div class="flex flex-wrap gap-3 mt-7"><a href="{{ route('patients.index') }}" class="btn-primary">ابدأ الآن <span>←</span></a><a href="{{ route('reports.index') }}" class="btn-secondary bg-white/80">تعرف على النظام</a></div>
                </div>
            </div>
        </section>
        <div class="max-w-7xl mx-auto px-5 sm:px-8 -mt-2 relative z-10 pb-10">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach([['المرضى','إدارة بيانات المرضى','patients.index','bg-primary-50'],['الأطباء','إدارة الفريق الطبي','doctors.index','bg-secondary-50'],['التقارير','تقارير واضحة وسريعة','reports.index','bg-amber-50'],['الأقسام','تنظيم أقسام المشفى','departments.index','bg-purple-50']] as $item)
                    <a href="{{ route($item[2]) }}" class="card p-5 text-center hover:-translate-y-1 transition-transform"><div class="w-14 h-14 mx-auto rounded-2xl {{ $item[3] }} flex items-center justify-center text-2xl text-primary-700">✦</div><h2 class="font-black text-primary-950 mt-4">{{ $item[0] }}</h2><p class="text-sm text-neutral-500 mt-2">{{ $item[1] }}</p></a>
                @endforeach
            </div>
            <div class="card mt-6 p-6"><div class="grid grid-cols-2 lg:grid-cols-4 divide-x divide-neutral-100 divide-x-reverse text-center"><div><strong class="block text-2xl text-primary-700">{{ $patientCount }}</strong><span class="text-sm text-neutral-500">إجمالي المرضى</span></div><div><strong class="block text-2xl text-primary-700">{{ $doctorCount }}</strong><span class="text-sm text-neutral-500">الأطباء</span></div><div><strong class="block text-2xl text-primary-700">{{ $departmentCount }}</strong><span class="text-sm text-neutral-500">الأقسام</span></div><div><strong class="block text-2xl text-secondary-600">24/7</strong><span class="text-sm text-neutral-500">دعم النظام</span></div></div></div>
            <div class="grid lg:grid-cols-2 gap-6 mt-6"><div class="card p-6"><h2 class="font-black text-primary-950 text-lg">إحصائيات اليوم <span class="text-secondary-600">▮▮</span></h2><div class="mt-6 h-32 flex items-end gap-3 border-b border-neutral-200">@foreach([35,65,48,78,92,60,74] as $height)<div class="flex-1 rounded-t-lg bg-primary-500/80" style="height: {{ $height }}%"></div>@endforeach</div><div class="flex justify-between text-xs text-neutral-400 mt-2"><span>السبت</span><span>الأحد</span><span>الإثنين</span><span>الثلاثاء</span><span>الأربعاء</span><span>الخميس</span><span>الجمعة</span></div></div><div class="card p-6"><h2 class="font-black text-primary-950 text-lg">آخر الأنشطة <span class="text-secondary-600">◷</span></h2><div class="mt-4 space-y-4">@foreach(['تم تسجيل مريض جديد','تمت إضافة طبيب جديد','تم إصدار تقرير طبي','تم تحديث بيانات القسم'] as $activity)<div class="flex items-center justify-between border-b border-neutral-100 pb-3"><span class="text-sm text-neutral-600">{{ $activity }}</span><span class="text-xs text-neutral-400">اليوم</span></div>@endforeach</div></div></div>
        </div>
    @else
        <section class="relative isolate overflow-hidden bg-cover bg-center min-h-[360px] sm:min-h-[410px]" style="background-image: url('{{ asset('images/nav.png') }}'); background-position: left center;">
            <div class="absolute inset-0 -z-10 bg-gradient-to-l from-white/95 via-white/75 to-white/15"></div>
            <div class="relative max-w-7xl mx-auto px-5 sm:px-8 py-16 sm:py-24 text-center">
                <p class="text-secondary-700 font-bold text-base sm:text-lg mb-4">مرحبًا بك في Vivio</p>
                <h1 class="text-3xl sm:text-5xl font-black leading-tight text-primary-950">مرحبًا بك في <span class="text-secondary-600">بوابتك الصحية</span></h1>
                <p class="text-primary-800 text-base sm:text-lg mt-5 leading-loose">لأن صحتك تهمنا .. نوفر لك تجربة سهلة ومريحة<br>لإدارة رحلتك العلاجية في مكان واحد.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-3 mt-7"><a href="#services" class="btn-primary min-w-44">استكشف خدماتنا <span>←</span></a><a href="{{ route('profile.edit') }}" class="btn-secondary bg-white/90 min-w-44">ملفي الشخصي</a></div>
            </div>
        </section>
        <div id="services" class="max-w-6xl mx-auto px-5 sm:px-8 py-10 sm:py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach([['تواصل معنا','نحن هنا لمساعدتك دائمًا','bg-violet-50','text-violet-600','رسالة'],['خدماتنا','تعرّف على الخدمات الطبية المتوفرة في مشفانا','bg-rose-50','text-rose-600','قلب'],['مواعيدي','عرض وإدارة مواعيدك بسهولة','bg-secondary-50','text-secondary-600','تقويم'],['سجلي الطبي','اطلع على جميع سجلاتك الطبية والفحوصات السابقة','bg-primary-50','text-primary-600','ملف']] as $service)
                    <a href="{{ route('profile.edit') }}" class="group card min-h-[190px] p-7 text-center hover:-translate-y-1 hover:border-primary-200 transition-all">
                        <div class="w-16 h-16 mx-auto rounded-full {{ $service[2] }} {{ $service[3] }} flex items-center justify-center font-black text-sm group-hover:scale-105 transition-transform">{{ $service[4] }}</div>
                        <h2 class="font-black text-primary-950 mt-5 text-lg">{{ $service[0] }}</h2>
                        <p class="text-sm text-neutral-500 mt-2 leading-relaxed">{{ $service[1] }}</p>
                    </a>
                @endforeach
            </div>
            <div class="relative overflow-hidden rounded-2xl mt-7 bg-gradient-to-l from-primary-50 via-white to-secondary-50 border border-white shadow-card p-7 sm:p-9 text-center sm:text-right">
                <div class="relative"><p class="text-secondary-700 font-bold mb-2">رعاية تضعك أولًا</p><h2 class="text-2xl font-black text-primary-950">معًا نحو رعاية صحية أفضل</h2><p class="text-neutral-600 mt-2 leading-relaxed">نلتزم بتقديم خدمات طبية متميزة وآمنة باستخدام أحدث التقنيات وفريق طبي متخصص.</p></div>
            </div>
        </div>
    @endif
</x-app-layout>
