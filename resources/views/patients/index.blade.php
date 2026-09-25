<x-app-layout>
    <div class="page-header-bg border-b border-primary-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5 ">
                <div>
                    <p class="text-primary-600 font-bold mb-2">إدارة البيانات الأساسية</p>
                    <h1 class="text-3xl font-black text-primary-950">المرضى</h1>
                    <p class="text-neutral-500 mt-2">إدارة ملفات المرضى وبيانات التواصل بشكل آمن.</p>
                </div>
                @if(auth()->user()->hasAnyRole(['admin', 'doctor', 'receptionist']))<a href="{{ route('patients.create') }}" class="btn-primary bg-secondary-600 hover:bg-secondary-700">+ إضافة مريض جديد</a>@endif
            </div>
        </div>
    </div>

    <div class=" max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        <div class="card mt-6 overflow-hidden">
            <div class="p-5 border-b border-neutral-100 flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-primary-950">قائمة المرضى</h2>
                    <p class="text-sm text-neutral-500 mt-1">{{ $patients->total() }} ملفًا مسجلًا</p>
                </div>
                <form method="GET" class="flex gap-2 w-full md:w-auto">
                    <input name="search" value="{{ request('search') }}" class="input-field md:w-80" placeholder="ابحث بالاسم أو رقم الهاتف...">
                    <button class="btn-blue px-4" aria-label="بحث">بحث</button>
                </form>
            </div>
            <div class="overflow-x-auto pt-5">
                <table class="w-full text-right min-w-[850px]">
                    <thead class="bg-primary-50 text-primary-900 text-sm">
                        <tr><th class="px-5 py-4">المريض</th><th class="px-5 py-4">رقم الهاتف</th><th class="px-5 py-4">الجنس</th><th class="px-5 py-4">تاريخ الميلاد</th><th class="px-5 py-4">فصيلة الدم</th><th class="px-5 py-4">الإجراءات</th></tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @forelse($patients as $patient)
                            <tr class="table-row-hover">
                                <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-11 h-11 rounded-full bg-secondary-100 text-secondary-700 flex items-center justify-center font-black">{{ mb_substr($patient->first_name, 0, 1) }}</div><div><a href="{{ route('patients.show', $patient) }}" class="font-bold text-primary-900 hover:text-secondary-700">{{ $patient->full_name }}</a><p class="text-xs text-neutral-400 mt-1">رقم الملف #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</p></div></div></td>
                                <td class="px-5 py-4 text-neutral-600">{{ $patient->phone }}</td>
                                <td class="px-5 py-4">{{ $patient->gender === 'male' ? 'ذكر' : 'أنثى' }}</td>
                                <td class="px-5 py-4 text-neutral-600">{{ $patient->birth_date->format('Y-m-d') }}</td>
                                <td class="px-5 py-4"><span class="badge badge-info">{{ $patient->blood_type ?: 'غير محدد' }}</span></td>
                                <td class="px-5 py-4"><div class="flex items-center gap-2"><a class="p-2 rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100" href="{{ route('patients.show', $patient) }}" title="عرض">عرض</a>@if(auth()->user()->hasAnyRole(['admin', 'doctor', 'receptionist']))<a class="p-2 rounded-lg bg-secondary-50 text-secondary-700 hover:bg-secondary-100" href="{{ route('patients.edit', $patient) }}" title="تعديل">تعديل</a>@endif
                                        @if(auth()->user()->hasRole('admin'))<form method="POST" action="{{ route('patients.destroy', $patient) }}" onsubmit="return confirm('هل تريد حذف هذا المريض؟')">@csrf @method('DELETE')<button class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100" title="حذف">حذف</button></form>@endif</div></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-16 text-center text-neutral-500">لا توجد ملفات مطابقة للبحث.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($patients->hasPages())<div class="p-5 border-t border-neutral-100">{{ $patients->links() }}</div>@endif
        </div>
    </div>
</x-app-layout>
