@extends('master')

@section('title', 'Tambah Data Gaji')
@section('page-title', 'Tambah Data Gaji')
@section('page-description', 'Isi form untuk menambahkan data gaji')

@section('content')
<div class="container">
    <div class="content-wrapper">
        
        <div class="mb-2">
            <a href="{{ route('salaries.index') }}" class="btn btn-outline btn-sm">
                ← Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Form Data Gaji</h2>
            </div>

            <form action="{{ route('salaries.store') }}" method="POST">
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
                        <!-- Pegawai (Full Width) -->
                        <div style="grid-column: span 2;">
                            <div class="form-group">
                                <label class="form-label">
                                    Pegawai <span class="text-danger">*</span>
                                </label>
                                <select name="karyawan_id" class="form-control" required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" 
                                                {{ old('karyawan_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->nama_lengkap }} - {{ $employee->position->nama_jabatan ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Bulan -->
                        <div>
                            <div class="form-group">
                                <label class="form-label">
                                    Bulan <span class="text-danger">*</span>
                                </label>
                                <input type="month" 
                                       name="bulan" 
                                       value="{{ old('bulan', date('Y-m')) }}"
                                       class="form-control" 
                                       required>
                            </div>
                        </div>

                        <!-- Gaji Pokok -->
                        <div>
                            <div class="form-group">
                                <label class="form-label">
                                    Gaji Pokok <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       name="gaji_pokok" 
                                       value="{{ oldg('gaji_pokok', 0) }}" 
                                       step="0.01"
                                       class="form-control" 
                                       placeholder="5000000" 
                                       required>
                            </div>
                        </div>

                        <!-- Tunjangan -->
                        <div>
                            <div class="form-group">
                                <label class="form-label">
                                    Tunjangan
                                </label>
                                <input type="number" 
                                       name="tunjangan" 
                                       value="{{ old('tunjangan', 0) }}" 
                                       step="0.01"
                                       class="form-control" 
                                       placeholder="500000">
                            </div>
                        </div>

                        <!-- Potongan -->
                        <div>
                            <div class="form-group">
                                <label class="form-label">
                                    Potongan
                                </label>
                                <input type="number" 
                                       name="potongan" 
                                       value="{{ old('potongan', 0) }}" 
                                       step="0.01"
                                       class="form-control" 
                                       placeholder="100000">
                            </div>
                        </div>

                        <!-- Info Total (Read Only) -->
                        <div style="grid-column: span 2;">
                            <div class="alert alert-info">
                                <strong>Catatan:</strong> Total gaji akan otomatis dihitung: Gaji Pokok + Tunjangan - Potongan
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer flex-between">
                    <div></div>
                    <div class="flex flex-gap-1">
                        <a href="{{ route('salaries.index') }}" class="btn btn-outline">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection