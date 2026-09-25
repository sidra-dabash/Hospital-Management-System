@if(session('success'))<div class="mb-6 rounded-xl bg-secondary-50 border border-secondary-100 text-secondary-800 px-4 py-3">{{ session('success') }}</div>@endif
@if(session('error'))<div class="mb-6 rounded-xl bg-red-50 border border-red-100 text-red-800 px-4 py-3">{{ session('error') }}</div>@endif
@if($errors->any())<div class="mb-6 rounded-xl bg-red-50 border border-red-100 text-red-800 px-4 py-3"><p class="font-bold mb-1">يرجى مراجعة البيانات المدخلة.</p><ul class="text-sm list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
