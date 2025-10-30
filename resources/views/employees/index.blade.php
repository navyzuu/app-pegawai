@extends('master')

@section('title', 'Daftar Pegawai')
@section('page-title', 'Daftar Pegawai')
@section('page-description', 'Kelola data pegawai perusahaan')

@section('content')

<div class="flex-between mb-3">
    <div>
        <p class="text-gray">Total: <strong>{{ $employees->count() }}</strong> pegawai</p>
    </div>
    <a href="{{ route('employees.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Tambah Pegawai
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Departemen</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="avatar avatar-sm">
                                {{ strtoupper(substr($employee->nama_lengkap, 0, 1)) }}
                            </div>
                            <strong>{{ $employee->nama_lengkap }}</strong>
                        </div>
                    </td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->nomor_telepon }}</td>
                    <td>{{ $employee->department->nama_departemen ?? '-' }}</td>
                    <td>{{ $employee->position->nama_jabatan ?? '-' }}</td>
                    <td>
                        @if($employee->status == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @elseif($employee->status == 'nonaktif')
                            <span class="badge badge-danger">Non-Aktif</span>
                        @else
                            <span class="badge badge-warning">{{ ucfirst($employee->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 4px;">
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-primary btn-sm">
                                Lihat
                            </a>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-md">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 48px;">
                        <p class="text-gray mb-2">Belum ada data pegawai</p>
                        <a href="{{ route('employees.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Pegawai Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection