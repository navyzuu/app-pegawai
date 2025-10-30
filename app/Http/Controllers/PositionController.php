<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function store(Request $request, Department $department)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        $validated['departemen_id'] = $department->id;
        Position::create($validated);

        return redirect()->route('departments.show', $department->id)
            ->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function update(Request $request, Department $department, Position $position)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        $position->update($validated);

        return redirect()->route('departments.show', $department->id)
            ->with('success', 'Jabatan berhasil diperbarui!');
    }

    public function destroy(Department $department, Position $position)
    {
        $position->delete();

        return redirect()->route('departments.show', $department->id)
            ->with('success', 'Jabatan berhasil dihapus!');
    }
}