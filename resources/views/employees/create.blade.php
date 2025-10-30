@extends('master')

@section('title', 'Tambah Pegawai')
@section('page-title', 'Tambah Pegawai Baru')
@section('page-description', 'Isi formulir untuk menambahkan pegawai')

@section('content')

<div style="max-width: 1500px; ">
    <div class="mb-2">
        <a href="{{ route('employees.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 style="margin: 0; font-size: 18px;">Form Pegawai Baru</h2>
        </div>

        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            
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

                <div class="grid-2">
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Nama Lengkap <span style="color: var(--danger);">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email <span style="color: var(--danger);">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Telepon <span style="color: var(--danger);">*</span></label>
                        <input type="tel" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir <span style="color: var(--danger);">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Masuk <span style="color: var(--danger);">*</span></label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Departemen <span style="color: var(--danger);">*</span></label>
                        <select name="departemen_id" class="form-control" required>
                            <option value="">Pilih Departemen</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('departemen_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jabatan <span style="color: var(--danger);">*</span></label>
                        <select name="jabatan_id" class="form-control" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('jabatan_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->nama_jabatan }} - Rp {{ number_format($position->gaji_pokok, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Status Pegawai <span style="color: var(--danger);">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Alamat Lengkap <span style="color: var(--danger);">*</span></label>
                        <textarea name="alamat" class="form-control" required>{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                    <a href="{{ route('employees.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection