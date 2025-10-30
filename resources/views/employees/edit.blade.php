@extends('master')

@section('title', 'Edit Pegawai')
@section('page-title', 'Edit Data Pegawai')
@section('page-description', 'Perbarui informasi pegawai')

@section('content')

<div style="max-width: 1500px;">
    <div class="mb-2">
        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 style="margin: 0; font-size: 18px;">Edit Data Pegawai</h2>
            <span class="badge badge-info">ID: {{ $employee->id }}</span>
        </div>

        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Terdapat kesalahan:</strong>
                    <ul style="margin: 8px 0 0 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="alert alert-info">
                    Anda sedang mengedit: <strong>{{ $employee->nama_lengkap }}</strong>
                </div>

                <div class="grid-2">
                    <!-- Nama Lengkap -->
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Nama Lengkap <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $employee->nama_lengkap) }}" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">Email <span style="color: var(--danger);">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon <span style="color: var(--danger);">*</span></label>
                        <input type="tel" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon', $employee->nomor_telepon) }}" required>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir <span style="color: var(--danger);">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $employee->tanggal_lahir) }}" required>
                    </div>

                    <!-- Tanggal Masuk -->
                    <div class="form-group">
                        <label class="form-label">Tanggal Masuk <span style="color: var(--danger);">*</span></label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $employee->tanggal_masuk) }}" required>
                    </div>

                    <!-- Departemen -->
                    <div class="form-group">
                        <label class="form-label">Departemen <span style="color: var(--danger);">*</span></label>
                        <select name="departemen_id" class="form-control" required>
                            <option value="">Pilih Departemen</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('departemen_id', $employee->departemen_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jabatan -->
                    <div class="form-group">
                        <label class="form-label">Jabatan <span style="color: var(--danger);">*</span></label>
                        <select name="jabatan_id" class="form-control" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('jabatan_id', $employee->jabatan_id) == $position->id ? 'selected' : '' }}>
                                    {{ $position->nama_jabatan }} - Rp {{ number_format($position->gaji_pokok, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Status Pegawai <span style="color: var(--danger);">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" {{ old('status', $employee->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $employee->status) == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Alamat Lengkap <span style="color: var(--danger);">*</span></label>
                        <textarea name="alamat" class="form-control" required>{{ old('alamat', $employee->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="text-sm text-gray">
                        Terakhir diubah: {{ $employee->updated_at ? $employee->updated_at->format('d/m/Y H:i') : '-' }}
                    </span>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection