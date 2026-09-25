<x-app-layout>
    <div class="page-header-bg border-b border-primary-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
                <div>
                    <p class="text-primary-600 font-bold mb-2">إدارة البيانات الأساسية</p>
                    <h1 class="text-3xl font-black text-primary-950">الأطباء</h1>
                    <p class="text-neutral-500 mt-2">إدارة الكادر الطبي وتوزيعه على الأقسام.</p>
                </div>
                <a href="{{ route('doctors.create') }}" class="btn-primary">+ إضافة طبيب جديد</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        <div class="card mt-6 overflow-hidden">
            <div class="p-5 border-b border-neutral-100 flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-primary-950">قائمة الأطباء</h2>
                    <p class="text-sm text-neutral-500 mt-1">{{ $doctors->total() }} طبيبًا مسجلًا</p>
                </div>
                <form method="GET" class="flex gap-2 w-full md:w-auto">
                    <input name="search" value="{{ request('search') }}" class="input-field md:w-80" placeholder="ابحث باسم الطبيب أو التخصص...">
                    <button class="btn-blue px-4">بحث</button>
                </form>
            </div>
            <div class="overflow-x-auto pt-5">
                <table class="w-full text-right min-w-[850px]">
                    <thead class="bg-primary-50 text-primary-900 text-sm">
                        <tr>
                            <th class="px-5 py-4">الطبيب</th>
                            <th class="px-5 py-4">التخصص</th>
                            <th class="px-5 py-4">القسم</th>
                            <th class="px-5 py-4">الهاتف</th>
                            <th class="px-5 py-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100">
                        @forelse($doctors as $doctor)
                            <tr class="table-row-hover">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-11 h-11 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-black">د</div>
                                        <div>
                                            <a href="{{ route('doctors.show', $doctor) }}" class="font-bold text-primary-900 hover:text-secondary-700">د. {{ $doctor->user->name }}</a>
                                            <p class="text-xs text-neutral-400 mt-1">{{ $doctor->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-neutral-600">{{ $doctor->specialization }}</td>
                                <td class="px-5 py-4"><span class="badge badge-success">{{ $doctor->department->name }}</span></td>
                                <td class="px-5 py-4 text-neutral-600">{{ $doctor->phone ?: 'غير مسجل' }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <a class="p-2 rounded-lg bg-primary-50 text-primary-700" href="{{ route('doctors.show', $doctor) }}">عرض</a>
                                        <a class="p-2 rounded-lg bg-secondary-50 text-secondary-700" href="{{ route('doctors.edit', $doctor) }}">تعديل</a>
                                        <form method="POST" action="{{ route('doctors.destroy', $doctor) }}" onsubmit="return confirm('هل تريد حذف هذا الطبيب؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100" title="حذف">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-16 text-center text-neutral-500">لا يوجد أطباء مسجلون.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($doctors->hasPages())
                <div class="p-5 border-t border-neutral-100">{{ $doctors->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
