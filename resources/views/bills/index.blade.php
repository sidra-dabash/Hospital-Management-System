<x-app-layout>
    <div class="page-header-bg border-b border-primary-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <p class="text-primary-600 font-bold mb-2 mt-3">الإدارة المالية</p>
                    <h1 class="text-3xl font-black text-primary-950">{{ $isPatient ? 'فواتيري' : 'الفواتير' }}</h1>
                    <p class="text-neutral-500 mt-2">متابعة الفواتير والحالة المالية.</p>
                </div>
                @unless($isPatient)<a href="{{ route('bills.create') }}" class="btn-primary mb-5">+ إنشاء فاتورة</a>@endunless
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @include('partials.flash')
        <div class="card mt-6 overflow-hidden">
            <div class="p-5 border-b border-neutral-100"><h2 class="text-lg font-bold text-primary-950">قائمة الفواتير</h2><p class="text-sm text-neutral-500 mt-1">{{ $bills->total() }} فاتورة</p></div>
            <div class="overflow-x-auto pt-5">
                <table class="w-full text-right min-w-[720px]">
                    <thead class="bg-primary-50 text-primary-900 text-sm"><tr><th class="px-5 py-4">الرقم</th>@unless($isPatient)<th class="px-5 py-4">المريض</th>@endunless<th class="px-5 py-4">المبلغ</th><th class="px-5 py-4">الحالة</th><th class="px-5 py-4">الإصدار</th><th class="px-5 py-4">الاستحقاق</th><th class="px-5 py-4">ملاحظات</th></tr></thead>
                    <tbody class="divide-y divide-neutral-100">
                        @forelse($bills as $bill)
                            <tr class="table-row-hover"><td class="px-5 py-4 font-bold text-primary-900">{{ $bill->id }}</td>@unless($isPatient)<td class="px-5 py-4 font-semibold">{{ $bill->patient?->full_name ?? '—' }}</td>@endunless<td class="px-5 py-4 font-bold">{{ number_format((float) $bill->amount, 2) }}</td><td class="px-5 py-4"><span class="badge {{ $bill->status === 'paid' ? 'badge-success' : ($bill->status === 'partial' ? 'badge-warning' : 'badge-danger') }}">{{ match($bill->status) { 'paid' => 'مدفوعة', 'partial' => 'مدفوعة جزئيًا', default => 'غير مدفوعة' } }}</span></td><td class="px-5 py-4 text-sm text-neutral-600">{{ $bill->issue_date?->format('Y-m-d') ?? '—' }}</td><td class="px-5 py-4 text-sm text-neutral-600">{{ $bill->due_date?->format('Y-m-d') ?? '—' }}</td><td class="px-5 py-4 text-sm text-neutral-600">{{ $bill->notes ?: '—' }}</td></tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-16 text-center text-neutral-500">لا توجد فواتير مسجلة حاليًا.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($bills->hasPages())<div class="p-5 border-t border-neutral-100">{{ $bills->links() }}</div>@endif
        </div>
    </div>
</x-app-layout>
