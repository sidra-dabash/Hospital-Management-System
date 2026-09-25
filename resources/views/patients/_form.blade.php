<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div><label class="block text-sm font-bold text-primary-900 mb-2">الاسم الأول <span class="text-red-500">*</span></label><input name="first_name" value="{{ old('first_name', $patient->first_name ?? '') }}" class="input-field" required></div>
    <div><label class="block text-sm font-bold text-primary-900 mb-2">اسم العائلة <span class="text-red-500">*</span></label><input name="last_name" value="{{ old('last_name', $patient->last_name ?? '') }}" class="input-field" required></div>
    <div><label class="block text-sm font-bold text-primary-900 mb-2">الجنس <span class="text-red-500">*</span></label><select name="gender" class="select-field" required><option value="">اختر الجنس</option><option value="male" @selected(old('gender', $patient->gender ?? '') === 'male')>ذكر</option><option value="female" @selected(old('gender', $patient->gender ?? '') === 'female')>أنثى</option></select></div>
    <div><label class="block text-sm font-bold text-primary-900 mb-2">تاريخ الميلاد <span class="text-red-500">*</span></label><input type="date" name="birth_date" value="{{ old('birth_date', isset($patient) ? $patient->birth_date->format('Y-m-d') : '') }}" class="input-field" required></div>
    <div><label class="block text-sm font-bold text-primary-900 mb-2">رقم الهاتف <span class="text-red-500">*</span></label><input name="phone" value="{{ old('phone', $patient->phone ?? '') }}" class="input-field" required></div>
    <div><label class="block text-sm font-bold text-primary-900 mb-2">فصيلة الدم</label><select name="blood_type" class="select-field"><option value="">غير محدد</option>@foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)<option value="{{ $type }}" @selected(old('blood_type', $patient->blood_type ?? '') === $type)>{{ $type }}</option>@endforeach</select></div>
    <div><label class="block text-sm font-bold text-primary-900 mb-2">جهة اتصال للطوارئ</label><input name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact ?? '') }}" class="input-field"></div>
    <div><label class="block text-sm font-bold text-primary-900 mb-2">العنوان</label><input name="address" value="{{ old('address', $patient->address ?? '') }}" class="input-field"></div>
</div>
@isset($patientUsers)
    <div class="mt-5">
        <label for="user_id" class="block text-sm font-bold text-primary-900 mb-2">حساب المريض</label>
        <select id="user_id" name="user_id" class="select-field">
            <option value="">لا يوجد حساب مرتبط</option>
            @foreach($patientUsers as $patientUser)
                <option value="{{ $patientUser->id }}" @selected(old('user_id', $patient->user_id ?? '') == $patientUser->id)>
                    {{ $patientUser->name }} — {{ $patientUser->email }}
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-neutral-500">اربط سجل المريض بحسابه حتى تظهر له بياناته الشخصية وفواتيره.</p>
    </div>
@endisset
