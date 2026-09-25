<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillController extends Controller
{
    public function index(): View
    {
        $isPatient = auth()->user()->hasRole('patient');
        $patient = $isPatient ? Patient::forUser(auth()->user()) : null;

        $bills = Bill::with('patient')
            ->when($isPatient, fn ($query) => $query->where('patient_id', $patient?->id ?? 0))
            ->latest('issue_date')
            ->latest('id')
            ->paginate(12);

        return view('bills.index', compact('bills', 'isPatient'));
    }

    public function create(): View
    {
        $patients = Patient::query()->orderBy('first_name')->orderBy('last_name')->get();

        return view('bills.create', compact('patients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:unpaid,paid,partial'],
            'issue_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'notes' => ['nullable', 'string'],
        ]);

        Bill::create($validated);

        return redirect()->route('bills.index')->with('success', 'تم إنشاء الفاتورة بنجاح.');
    }
}
