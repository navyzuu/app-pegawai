<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount(['positions', 'employees'])->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function show(Department $department)
    {
        $department->load('positions');
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        $department->update($validated);

        return redirect()->route('departments.show', $department->id)
            ->with('success', 'Departemen berhasil diperbarui!');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil dihapus!');
    }
}