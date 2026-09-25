<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8"><a href="{{ route('patients.index') }}" class="text-primary-600 font-bold text-sm">← العودة إلى قائمة المرضى</a><h1 class="text-3xl font-black text-primary-950 mt-4">تعديل بيانات المريض</h1><p class="text-neutral-500 mt-2">حدّث بيانات {{ $patient->full_name }} مع الحفاظ على سجلّه الطبي.</p></div>
        @include('partials.flash')
        <form method="POST" action="{{ route('patients.update', $patient) }}" class="card p-6 sm:p-8">@csrf @method('PUT')
            <div class="border-b border-neutral-100 pb-5 mb-6"><h2 class="text-xl font-bold text-primary-900">البيانات الشخصية</h2></div>
            @include('patients._form')
            <div class="flex flex-col-reverse sm:flex-row gap-3 justify-end mt-8 pt-6 border-t border-neutral-100"><a href="{{ route('patients.index') }}" class="btn-secondary">إلغاء</a><button class="btn-primary">حفظ التعديلات</button></div>
        </form>
    </div>
</x-app-layout>
