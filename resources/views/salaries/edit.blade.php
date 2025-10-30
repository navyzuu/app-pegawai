@extends('master')

@section('title', 'Edit Data Gaji')
@section('page-title', 'Edit Data Gaji')
@section('page-description', 'Perbarui data gaji')

@section('content')
<div class="container">
    <div class="content-wrapper">
        
        <div class="mb-2">
            <a href="{{ route('salaries.show', $salary->id) }}" class="btn btn-outline btn-sm">
                ← Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Edit Data Gaji</h2>
                <span class="badge badge-info">ID: {{ $salary->id }}</span>
            </div>

            <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
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
                        Anda sedang mengedit data gaji: <strong>{{ $salary->employee->nama_lengkap }} - {{ $salary->bulan }}</strong>
                    </div>

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
                                                {{ old('karyawan_id', $salary->karyawan_id) == $employee->id ? 'selected' : '' }}>
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
                                       value="{{ old('bulan', $salary->bulan) }}"
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
                                       value="{{ old('gaji_pokok', $salary->gaji_pokok) }}" 
                                       step="0.01"
                                       class="form-control" 
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
                                       value="{{ old('tunjangan', $salary->tunjangan) }}" 
                                       step="0.01"
                                       class="form-control">
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
                                       value="{{ old('potongan', $salary->potongan) }}" 
                                       step="0.01"
                                       class="form-control">
                            </div>
                        </div>
                        <div style="grid-column: span 2;">
                            <div class="alert alert-success">
                                <strong>Total Gaji Saat Ini:</strong> Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}
                                <br>
                                <span class="text-sm">Total akan diperbarui otomatis setelah disimpan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer flex-between">
                    <span class="text-sm text-gray">
                        Terakhir diubah: {{ $salary->updated_at->format('d/m/Y H:i') }}
                    </span>
                    <div class="flex flex-gap-1">
                        <a href="{{ route('salaries.show', $salary->id) }}" class="btn btn-outline">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection