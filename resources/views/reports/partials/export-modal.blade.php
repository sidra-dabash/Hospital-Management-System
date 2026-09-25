<div x-show="showExportModal"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="modal-backdrop" x-cloak>

    <div x-show="showExportModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="modal-content w-full max-w-xl"
         @click.outside="showExportModal = false">

        <div class="p-7">
            <div class="flex items-start justify-between mb-2">
                <button @click="showExportModal = false" class="p-2 rounded-xl hover:bg-neutral-100 transition-colors">
                    <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <div class="text-right">
                    <div class="flex items-center gap-2 justify-end">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-neutral-800">تصدير التقرير</h2>
                    </div>
                    <p class="text-neutral-500 text-sm mt-2 mr-13">اختر نوع التقرير والفترة الزمنية لتصدير التقرير المطلوب</p>
                </div>
            </div>

            <form method="POST" action="{{ route('reports.export.pdf') }}" class="mt-6 space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-neutral-700 mb-2 flex items-center gap-2 justify-end">
                        نوع التقرير
                        <div class="w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </label>
                    <div class="relative">
                        <select name="type" class="select-field pr-12">
                            <option value="تقرير المرضى الشهري">تقرير المرضى الشهري</option>
                            <option value="تقرير المواعيد">تقرير المواعيد</option>
                            <option value="تقرير العيادات">تقرير العيادات</option>
                            <option value="تقرير الإيرادات">تقرير الإيرادات</option>
                            <option value="تقرير المرضى الجدد">تقرير المرضى الجدد</option>
                        </select>
                        <svg class="w-4.5 h-4.5 absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-700 mb-3 text-right">الفترة الزمنية</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-neutral-500 mb-1.5 text-right">إلى</label>
                            <div class="relative">
                                <input type="date" name="date_to" value="2025-04-30" class="input-field pl-11">
                                <div class="absolute left-3.5 top-1/2 -translate-y-1/2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-neutral-500 mb-1.5 text-right">من</label>
                            <div class="relative">
                                <input type="date" name="date_from" value="2025-04-01" class="input-field pl-11">
                                <div class="absolute left-3.5 top-1/2 -translate-y-1/2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-700 mb-3 text-right">صيغة الملف</label>
                    <div class="grid grid-cols-1 gap-3">
                        <label class="relative flex items-center p-4 border-2 rounded-2xl cursor-pointer transition-all duration-200 bg-red-50 border-red-300 ring-2 ring-red-200">
                            <input type="radio" name="format" value="pdf" checked class="sr-only peer">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full border-2 border-red-500 peer-checked:bg-red-500 peer-checked:border-red-500 transition-colors flex items-center justify-center">
                                <div class="w-2 h-2 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                            </div>
                            <div class="flex items-center gap-3 mr-7">
                                <div class="w-11 h-11 rounded-xl bg-white shadow-soft flex items-center justify-center">
                                    <svg class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2l5 5h-5V4zM6 20V4h5v7h7v9H6z"/>
                                        <text x="12" y="18" text-anchor="middle" font-size="6" font-weight="bold" fill="#ef4444" font-family="Arial">PDF</text>
                                    </svg>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-neutral-800">PDF</div>
                                    <div class="text-xs text-neutral-500">صيغة الملف القياسية للتقارير</div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 pt-4 border-t border-neutral-100">
                    <button type="button" @click="showExportModal = false"
                            class="flex-1 px-6 py-3.5 rounded-xl border-2 border-neutral-200 text-neutral-700 font-bold hover:bg-neutral-50 transition-colors">
                        إلغاء
                    </button>
                    <button type="submit"
                            class="flex-1 btn-primary py-3.5 text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        تصدير التقرير
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
