@extends('master')

@section('title', 'Attendance')
@section('page-title', 'Attendance Management')
@section('page-description', 'Clock in/out pegawai hari ini')

@section('content')
<div class="container">
    <div class="content-wrapper">
        
        <!-- Header with Date and Actions -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 style="margin: 0;">Absensi Hari Ini</h2>
                    <p style="margin: 4px 0 0 0; font-size: 14px; opacity: 0.9;">
                        {{ \Carbon\Carbon::parse($today)->isoFormat('dddd, D MMMM YYYY') }}
                    </p>
                </div>
                <div class="flex flex-gap-1">
                    @if(request('mode') === 'edit')
                        <a href="{{ route('attendance.index') }}" class="btn btn-outline btn-sm">
                            Selesai Edit
                        </a>
                    @else
                        <a href="{{ route('attendance.index', ['mode' => 'edit']) }}" class="btn btn-warning btn-sm">
                            Mode Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif


        <!-- Search Form -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('attendance.index') }}" method="GET" class="flex flex-gap-1">
                    @if(request('mode'))
                        <input type="hidden" name="mode" value="{{ request('mode') }}">
                    @endif
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari pegawai..."
                           value="{{ request('search') }}"
                           style="max-width: 400px;">
                    <button type="submit" class="btn btn-primary">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('attendance.index', request()->except('search')) }}" class="btn btn-outline">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Edit Status Form (Show when mode=edit and karyawan selected) -->
        @if(request('mode') === 'edit' && request('karyawan_id'))
            @php
                $editkaryawan = $karyawan->firstWhere('id', request('karyawan_id'));
            @endphp
            @if($editkaryawan && $editkaryawan->todayAttendance)
            <div class="card">
                <div class="card-header">
                    <h3>Edit Status Kehadiran</h3>
                    <a href="{{ route('attendance.index', ['mode' => 'edit']) }}" class="btn btn-outline btn-sm">
                        Tutup
                    </a>
                </div>
                <form action="{{ route('attendance.update', $editkaryawan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Nama Pegawai</label>
                            <input type="text" 
                                   class="form-control bg-gray" 
                                   value="{{ $editkaryawan->nama_lengkap }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Status Kehadiran <span class="text-danger">*</span>
                            </label>
                            <select name="status_absensi" class="form-control" required>
                                <option value="hadir" {{ $editkaryawan->todayAttendance->status_absensi == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ $editkaryawan->todayAttendance->status_absensi == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ $editkaryawan->todayAttendance->status_absensi == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpha" {{ $editkaryawan->todayAttendance->status_absensi == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>

                        <div class="alert alert-warning">
                            <strong>Catatan:</strong> Jika status diubah dari "Hadir" ke status lain, waktu masuk/keluar akan dihapus.
                        </div>
                    </div>

                    <div class="card-footer flex-between">
                        <div></div>
                        <div class="flex flex-gap-1">
                            <a href="{{ route('attendance.index', ['mode' => 'edit']) }}" class="btn btn-outline">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        @endif

        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>Departemen</th>
                                <th>Jabatan</th>
                                <th style="text-align: center;">Jam Masuk</th>
                                <th style="text-align: center;">Jam Keluar</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($karyawan as $karyawan)
                            <tr>
                                <!-- Nama -->
                                <td>
                                    <div class="flex" style="align-items: center; gap: 8px;">
                                        <div class="avatar avatar-sm">
                                            {{ strtoupper(substr($karyawan->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <strong>{{ $karyawan->nama_lengkap }}</strong>
                                    </div>
                                </td>

                                <!-- Departemen -->
                                <td>{{ $karyawan->department->nama_departemen ?? '-' }}</td>

                                <!-- Jabatan -->
                                <td>{{ $karyawan->position->nama_jabatan ?? '-' }}</td>

                                <!-- Jam Masuk -->
                                <td style="text-align: center;">
                                    @if($karyawan->todayAttendance && $karyawan->todayAttendance->waktu_masuk)
                                        <span class="badge badge-success">
                                            {{ \Carbon\Carbon::parse($karyawan->todayAttendance->waktu_masuk)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-gray text-sm">-</span>
                                    @endif
                                </td>

                                <!-- Jam Keluar -->
                                <td style="text-align: center;">
                                    @if($karyawan->todayAttendance && $karyawan->todayAttendance->waktu_keluar)
                                        <span class="badge badge-info">
                                            {{ \Carbon\Carbon::parse($karyawan->todayAttendance->waktu_keluar)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-gray text-sm">-</span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td>
                                    <div class="flex flex-center flex-gap-1">
                                        @if(!$karyawan->todayAttendance)
                                            <!-- Belum Ada Record - Tampil Form Status -->
                                            <form action="{{ route('attendance.store', $karyawan->id) }}" method="POST" class="flex flex-gap-1">
                                                @csrf
                                                <select name="status_absensi" class="form-control" style="width: auto; padding: 6px 10px; font-size: 12px;" required>
                                                    <option value="hadir">Hadir</option>
                                                    <option value="izin">Izin</option>
                                                    <option value="sakit">Sakit</option>
                                                    <option value="alpha">Alpha</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    Submit
                                                </button>
                                            </form>
                                        @else
                                            <!-- Sudah Ada Record -->
                                            @if($karyawan->todayAttendance->status_absensi == 'hadir')
                                                <!-- Status Hadir - Tampil Clock In/Out -->
                                                @if(!$karyawan->todayAttendance->waktu_masuk)
                                                    <form action="{{ route('attendance.clock-in', $karyawan->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            Masuk
                                                        </button>
                                                    </form>
                                                @elseif(!$karyawan->todayAttendance->waktu_keluar)
                                                    <form action="{{ route('attendance.clock-out', $karyawan->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            Keluar
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge badge-primary">
                                                        Selesai
                                                    </span>
                                                @endif
                                            @else
                                                <!-- Status Selain Hadir (Izin/Sakit/Alpha) -->
                                                <span class="badge badge-warning">
                                                    {{ ucfirst($karyawan->todayAttendance->status_absensi) }}
                                                </span>
                                            @endif
                                            
                                            <!-- Tombol Edit (Tampil saat Mode Edit) -->
                                            @if(request('mode') === 'edit')
                                                <a href="{{ route('attendance.index', ['mode' => 'edit', 'karyawan_id' => $karyawan->id] + request()->except(['karyawan_id'])) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 48px 0;">
                                    <p class="text-gray">
                                        @if(request('search'))
                                            Tidak ada hasil untuk "{{ request('search') }}"
                                        @else
                                            Belum ada data pegawai aktif
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection