@extends('master')

@section('title', 'Daftar Gaji')
@section('page-title', 'Daftar Gaji')
@section('page-description', 'Kelola data gaji pegawai')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 style="margin: 0;">Data Gaji Pegawai</h2>
                    <p style="margin: 4px 0 0 0; font-size: 14px; opacity: 0.9;">
                        Total: {{ $salaries->count() }} data gaji
                    </p>
                </div>
                <a href="{{ route('salaries.create') }}" class="btn btn-primary">
                    + Tambah Data Gaji
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('salaries.index') }}" method="GET" class="flex flex-gap-1">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari data gaji..."
                           value="{{ request('search') }}"
                           style="max-width: 400px;">
                    <button type="submit" class="btn btn-primary">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('salaries.index') }}" class="btn btn-outline">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>Bulan</th>
                                <th style="text-align: right;">Gaji Pokok</th>
                                <th style="text-align: right;">Tunjangan</th>
                                <th style="text-align: right;">Potongan</th>
                                <th style="text-align: right;">Total Gaji</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salaries as $salary)
                            <tr>
                                <!-- Nama Pegawai -->
                                <td>
                                    <div class="flex" style="align-items: center; gap: 8px;">
                                        <div class="avatar avatar-sm">
                                            {{ strtoupper(substr($salary->employee->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong style="display: block;">{{ $salary->employee->nama_lengkap }}</strong>
                                            <span class="text-sm text-gray">{{ $salary->employee->position->nama_jabatan ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Bulan -->
                                <td>
                                    <span class="badge badge-primary">
                                        {{ $salary->bulan }}
                                    </span>
                                </td>

                                <!-- Gaji Pokok -->
                                <td style="text-align: right;">
                                    <strong>Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</strong>
                                </td>

                                <!-- Tunjangan -->
                                <td style="text-align: right; color: var(--success);">
                                    + Rp {{ number_format($salary->tunjangan, 0, ',', '.') }}
                                </td>

                                <!-- Potongan -->
                                <td style="text-align: right; color: var(--danger);">
                                    - Rp {{ number_format($salary->potongan, 0, ',', '.') }}
                                </td>

                                <!-- Total -->
                                <td style="text-align: right;">
                                    <strong class="text-primary" style="font-size: 15px;">
                                        Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td>
                                    <div class="flex flex-center flex-gap-1">
                                        <a href="{{ route('salaries.show', $salary->id) }}" 
                                           class="btn btn-primary btn-sm">
                                            Detail
                                        </a>
                                        <a href="{{ route('salaries.edit', $salary->id) }}" 
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('salaries.destroy', $salary->id) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Yakin ingin menghapus data gaji ini?')">
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
                                <td colspan="7" style="text-align: center; padding: 48px 0;">
                                    <p class="text-gray mb-2">
                                        @if(request('search'))
                                            Tidak ada hasil untuk "{{ request('search') }}"
                                        @else
                                            Belum ada data gaji
                                        @endif
                                    </p>
                                    @if(!request('search'))
                                    <a href="{{ route('salaries.create') }}" class="btn btn-primary btn-sm">
                                        + Tambah Data Gaji Pertama
                                    </a>
                                    @endif
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