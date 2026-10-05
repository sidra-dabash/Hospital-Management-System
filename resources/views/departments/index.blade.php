<x-app-layout>
    <div class="page-header-bg border-b border-primary-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <p class="text-primary-600 font-bold mb-2">إدارة البيانات الأساسية</p>
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
                <div>
                    <h1 class="text-3xl font-black text-primary-950">الأقسام الطبية</h1>
                    <p class="text-neutral-500 mt-2">تنظيم أقسام المشفى والتخصصات التابعة لها.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('partials.flash')
        <div class="grid lg:grid-cols-[300px_1fr] gap-6 items-start mt-6">
            <section id="add-department" class="card p-6 lg:sticky lg:top-24">
                <div class="w-14 h-14 rounded-2xl bg-secondary-50 text-secondary-700 flex items-center justify-center text-2xl mb-4">+</div>
                <h2 class="text-xl font-black text-primary-950">إضافة قسم</h2>
                <p class="text-sm text-neutral-500 mt-2 mb-5">أدخل بيانات القسم الطبي الجديد.</p>
                <form method="POST" action="{{ route('departments.store') }}" class="space-y-4">
                    @csrf
                    <label class="block text-sm font-bold text-primary-900">اسم القسم <span class="text-red-500">*</span><input name="name" class="input-field mt-2" required placeholder="مثال: طب الأطفال"></label>
                    <label class="block text-sm font-bold text-primary-900">الوصف<textarea name="description" class="input-field mt-2" rows="4" placeholder="وصف مختصر للقسم"></textarea></label>
                    <button class="btn-primary w-full">حفظ القسم</button>
                </form>
            </section>

            <section>
                <div class="flex items-center justify-between mb-4"><div><h2 class="text-xl font-black text-primary-950">كل الأقسام</h2><p class="text-sm text-neutral-500 mt-1">{{ $departments->count() }} أقسام مسجلة في المشفى</p></div></div>
                <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5 mt-6">
                    @forelse($departments as $department)
                        <article class="card overflow-hidden group">
                            <div class="h-2 bg-gradient-to-l from-primary-600 to-secondary-500"></div>
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-3"><div class="w-14 h-14 rounded-2xl bg-primary-50 text-primary-700 flex items-center justify-center text-2xl font-black">✚</div></div>
                                <h3 class="text-lg font-black text-primary-950 mt-5">{{ $department->name }}</h3>
                                <p class="text-sm text-neutral-500 leading-relaxed mt-2 min-h-[42px]">{{ $department->description ?: 'قسم طبي متخصص ضمن منظومة المشفى.' }}</p>
                                <div class="flex items-center justify-between mt-5 pt-4 border-t border-neutral-100"><span class="text-sm text-neutral-600"><strong class="text-primary-700">{{ $department->doctors_count }}</strong> أطباء</span><span class="text-xs text-secondary-700 bg-secondary-50 px-3 py-1 rounded-full">نشط</span></div>
                                <details class="mt-4"><summary class="cursor-pointer text-sm font-bold text-primary-700">تعديل القسم</summary><form method="POST" action="{{ route('departments.update', $department) }}" class="space-y-3 mt-3">@csrf @method('PUT')<input name="name" value="{{ $department->name }}" class="input-field text-sm" required><textarea name="description" class="input-field text-sm" rows="2">{{ $department->description }}</textarea><button class="btn-blue w-full text-sm">حفظ التعديل</button></form></details>
                                <form method="POST" action="{{ route('departments.destroy', $department) }}" class="mt-2" onsubmit="return confirm('هل تريد حذف هذا القسم؟')">@csrf @method('DELETE')<button class="w-full py-2 text-sm font-bold text-red-600 hover:bg-red-50 rounded-lg transition">حذف القسم</button></form>
                            </div>
                        </article>
                    @empty
                        <div class="card p-12 text-center sm:col-span-2 xl:col-span-3 text-neutral-500">لا توجد أقسام مسجلة حتى الآن.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
