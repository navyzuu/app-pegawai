<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with('employee')->orderBy('bulan', 'desc')->get();
        return view('salaries.index', compact('salaries'));
    }

    public function create()
    {
        $employees = Employee::with('position')->get();
        return view('salaries.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'bulan' => 'required|string|max:10',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
        ]);

        $validated['tunjangan'] = $validated['tunjangan'] ?? 0;
        $validated['potongan'] = $validated['potongan'] ?? 0;
        $validated['total_gaji'] = $validated['gaji_pokok'] + $validated['tunjangan'] - $validated['potongan'];

        Salary::create($validated);

        return redirect()->route('salaries.index')
            ->with('success', 'Data gaji berhasil ditambahkan!');
    }

    public function show(Salary $salary)
    {
        $salary->load('employee.position', 'employee.department');
        return view('salaries.show', compact('salary'));
    }

    public function edit(Salary $salary)
    {
        $employees = Employee::with('position')->get();
        return view('salaries.edit', compact('salary', 'employees'));
    }

    public function update(Request $request, Salary $salary)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'bulan' => 'required|string|max:10',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
        ]);

        $validated['tunjangan'] = $validated['tunjangan'] ?? 0;
        $validated['potongan'] = $validated['potongan'] ?? 0;
        $validated['total_gaji'] = $validated['gaji_pokok'] + $validated['tunjangan'] - $validated['potongan'];

        $salary->update($validated);

        return redirect()->route('salaries.show', $salary->id)
            ->with('success', 'Data gaji berhasil diperbarui!');
    }

    public function destroy(Salary $salary)
    {
        $salary->delete();

        return redirect()->route('salaries.index')
            ->with('success', 'Data gaji berhasil dihapus!');
    }
}