<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['department', 'position'])->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'required|exists:departments,id',
            'jabatan_id' => 'required|exists:positions,id',
            'status' => 'required|in:aktif,nonaktif,cuti',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Pegawai berhasil ditambahkan!');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'position']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'required|exists:departments,id',
            'jabatan_id' => 'required|exists:positions,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.show', $employee->id)
            ->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function getPositionsByDepartment($departmentId)
    {
        $positions = Position::where('departemen_id', $departmentId)->get();
        return response()->json($positions);
    }
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Pegawai berhasil dihapus!');
    }

    
}
