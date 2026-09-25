<x-app-layout>
    <div class="page-header-bg border-b border-primary-100"><div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8"><a href="{{ route('bills.index') }}" class="text-primary-600 font-bold text-sm">← العودة إلى الفواتير</a><h1 class="text-3xl font-black text-primary-950 mt-4">إنشاء فاتورة</h1><p class="text-neutral-500 mt-2">إضافة فاتورة مرتبطة بملف المريض.</p></div></div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($errors->any())<div class="mb-5 rounded-xl bg-red-50 border border-red-100 px-5 py-4 text-red-700"><ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('bills.store') }}" class="card p-6 sm:p-8 space-y-6">@csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div><label for="patient_id" class="block text-sm font-bold text-primary-900 mb-2">المريض *</label><select id="patient_id" name="patient_id" class="select-field" required><option value="">اختر المريض</option>@foreach($patients as $patient)<option value="{{ $patient->id }}" @selected(old('patient_id', request('patient_id')) == $patient->id)>{{ $patient->full_name }}</option>@endforeach</select></div>
                <div><label for="amount" class="block text-sm font-bold text-primary-900 mb-2">المبلغ *</label><input id="amount" name="amount" type="number" min="0" step="0.01" value="{{ old('amount') }}" class="input-field" required></div>
                <div><label for="status" class="block text-sm font-bold text-primary-900 mb-2">الحالة *</label><select id="status" name="status" class="select-field" required><option value="unpaid">غير مدفوعة</option><option value="paid">مدفوعة</option><option value="partial">مدفوعة جزئيًا</option></select></div>
                <div><label for="issue_date" class="block text-sm font-bold text-primary-900 mb-2">تاريخ الإصدار *</label><input id="issue_date" name="issue_date" type="date" value="{{ old('issue_date', now()->toDateString()) }}" class="input-field" required></div>
                <div><label for="due_date" class="block text-sm font-bold text-primary-900 mb-2">تاريخ الاستحقاق</label><input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}" class="input-field"></div>
            </div>
            <div><label for="notes" class="block text-sm font-bold text-primary-900 mb-2">ملاحظات</label><textarea id="notes" name="notes" rows="4" class="input-field">{{ old('notes') }}</textarea></div>
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 border-t border-neutral-100 pt-5"><a href="{{ route('bills.index') }}" class="btn-secondary">إلغاء</a><button class="btn-primary" type="submit">حفظ الفاتورة</button></div>
        </form>
    </div>
</x-app-layout>
