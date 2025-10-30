@extends('master')

@section('title', 'Detail Departemen')
@section('page-title', 'Detail Departemen')
@section('page-description', 'Informasi departemen dan daftar jabatan')

@section('content')
<div class="container">
    <div class="content-wrapper">
        
        <div class="mb-2">
            <a href="{{ route('departments.index') }}" class="btn btn-outline btn-sm">
                ← Kembali ke Daftar Departemen
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Department Info Card -->
        <div class="card">
            <div class="card-header">
                <div class="flex" style="align-items: center; gap: 16px;">
                    <div class="avatar avatar-lg bg-secondary">
                        <span>{{ substr($department->nama_departemen, 0, 1) }}</span>
                    </div>
                    <div>
                        <h2 style="margin: 0; font-size: 24px;">{{ $department->nama_departemen }}</h2>
                        <p style="margin: 4px 0 0 0; font-size: 14px; opacity: 0.9;">
                            {{ $department->positions->count() }} Jabatan • {{ $department->employees->count() }} Pegawai
                        </p>
                    </div>
                </div>
                <div class="flex flex-gap-1">
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-accent btn-sm">
                        Edit
                    </a>
                    <form action="{{ route('departments.destroy', $department->id) }}" 
                          method="POST" 
                          style="display: inline;"
                          onsubmit="return confirm('Yakin ingin menghapus departemen ini? Semua jabatan dan data terkait akan ikut terhapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-md">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Position Form -->
        @if(request('action') === 'add')
        <div class="card">
            <div class="card-header">
                <h3>Tambah Jabatan Baru</h3>
                <a href="{{ route('departments.show', $department->id) }}" class="btn btn-outline btn-md">
                    Tutup
                </a>
            </div>
            <form action="{{ route('departments.positions.store', $department->id) }}" method="POST">
                @csrf
                
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">
                            Nama Jabatan <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nama_jabatan" 
                               class="form-control" 
                               placeholder="Contoh: Manager" 
                               value="{{ old('nama_jabatan') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Gaji Pokok <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               name="gaji_pokok" 
                               step="0.01"
                               class="form-control" 
                               placeholder="5000000"
                               value="{{ old('gaji_pokok') }}"
                               required>
                    </div>
                </div>

                <div class="card-footer flex-between">
                    <div></div>
                    <div class="flex flex-gap-1">
                        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-outline">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @endif

        <!-- Edit Position Form -->
        @if(request('action') === 'edit' && request('position_id'))
        @php
            $editPosition = $department->positions->firstWhere('id', request('position_id'));
        @endphp
        @if($editPosition)
        <div class="card">
            <div class="card-header">
                <h3>Edit Jabatan</h3>
                <a href="{{ route('departments.show', $department->id) }}" class="btn btn-outline btn-md">
                    Tutup
                </a>
            </div>
            <form action="{{ route('departments.positions.update', [$department->id, $editPosition->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">
                            Nama Jabatan <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nama_jabatan" 
                               class="form-control" 
                               value="{{ old('nama_jabatan', $editPosition->nama_jabatan) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Gaji Pokok <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               name="gaji_pokok" 
                               step="0.01"
                               class="form-control" 
                               value="{{ old('gaji_pokok', $editPosition->gaji_pokok) }}"
                               required>
                    </div>
                </div>

                <div class="card-footer flex-between">
                    <div></div>
                    <div class="flex flex-gap-1">
                        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-outline">
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

        <!-- Positions Section -->
        <div class="card">
            <div class="card-header">
                <h3>Daftar Jabatan</h3>
                <a href="{{ route('departments.show', [$department->id, 'action' => 'add']) }}" 
                   class="btn btn-primary btn-sm">
                    + Tambah Jabatan
                </a>
            </div>

            <div class="card-body">
                @if($department->positions->count() > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Jabatan</th>
                                <th>Gaji Pokok</th>
                                <th>Jumlah Pegawai</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($department->positions as $position)
                            <tr>
                                <td><strong>{{ $position->nama_jabatan }}</strong></td>
                                <td>Rp {{ number_format($position->gaji_pokok, 0, ',', '.') }}</td>
                                <td>{{ $position->employees->count() }} orang</td>
                                <td>
                                    <div class="flex flex-center flex-gap-1">
                                        <a href="{{ route('departments.show', [$department->id, 'action' => 'edit', 'position_id' => $position->id]) }}" 
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('departments.positions.destroy', [$department->id, $position->id]) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-md">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center" style="padding: 48px 0;">
                    <p class="text-gray mb-2">Belum ada jabatan di departemen ini</p>
                    <a href="{{ route('departments.show', [$department->id, 'action' => 'add']) }}" 
                       class="btn btn-primary btn-sm">
                        + Tambah Jabatan Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection