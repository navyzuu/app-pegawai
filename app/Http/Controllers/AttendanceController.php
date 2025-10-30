<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
$today = Carbon::now()->format('Y-m-d');
        
        // Query hanya employee yang aktif
        $query = Employee::with(['department', 'position'])
            ->where('status', 'aktif'); // Filter hanya pegawai aktif
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhereHas('department', function($q) use ($search) {
                      $q->where('nama_departemen', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('position', function($q) use ($search) {
                      $q->where('nama_jabatan', 'like', '%' . $search . '%');
                  });
            });
        }
        
        $karyawan = $query->orderBy('nama_lengkap')->get();
        
        // Tambahkan relasi todayAttendance untuk setiap employee
        $karyawan->each(function($karyawan) use ($today) {
            $karyawan->todayAttendance = Attendance::where('karyawan_id', $karyawan->id)
                ->whereDate('tanggal', $today)
                ->first();
        });
        
        return view('attendance.index', compact('karyawan', 'today'));
    }

        public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha'
        ]);

        $today = Carbon::today()->format('Y-m-d');
        
        $attendance = Attendance::create([
            'karyawan_id' => $employee->id,
            'tanggal' => $today,
            'status_absensi' => $validated['status_absensi'],
            'waktu_masuk' => $validated['status_absensi'] == 'hadir' ? null : null,
            'waktu_keluar' => null
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Status kehadiran ' . $employee->nama_lengkap . ' berhasil dicatat!');
    }

    public function clockIn(Request $request, Employee $employee)
    {
        $today = Carbon::today()->format('Y-m-d');
        
        $attendance = Attendance::updateOrCreate(
            [
                'karyawan_id' => $employee->id,
                'tanggal' => $today
            ],
            [
                'waktu_masuk' => Carbon::now()->format('H:i:s'),
                'status_absensi' => 'hadir'
            ]
        );

        return redirect()->route('attendance.index')
            ->with('success', $employee->nama_lengkap . ' berhasil clock in!');
    }

    public function clockOut(Request $request, Employee $employee)
    {
        $today = Carbon::today()->format('Y-m-d');
        
        $attendance = Attendance::where('karyawan_id', $employee->id)
            ->where('tanggal', $today)
            ->first();

        if ($attendance) {
            $attendance->update([
                'waktu_keluar' => Carbon::now()->format('H:i:s')
            ]);

            return redirect()->route('attendance.index')
                ->with('success', $employee->nama_lengkap . ' berhasil clock out!');
        }

        return redirect()->route('attendance.index')
            ->with('error', 'Belum clock in!');
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha'
        ]);

        $today = Carbon::today()->format('Y-m-d');
        
        $attendance = Attendance::where('karyawan_id', $employee->id)
            ->where('tanggal', $today)
            ->first();

        if ($attendance) {
            $updateData = [
                'status_absensi' => $validated['status_absensi']
            ];

            if ($validated['status_absensi'] != 'hadir') {
                $updateData['waktu_masuk'] = null;
                $updateData['waktu_keluar'] = null;
            }

            $attendance->update($updateData);

            return redirect()->route('attendance.index')
                ->with('success', 'Status kehadiran ' . $employee->nama_lengkap . ' berhasil diperbarui!');
        }

        return redirect()->route('attendance.index')
            ->with('error', 'Data attendance tidak ditemukan!');
    }
}