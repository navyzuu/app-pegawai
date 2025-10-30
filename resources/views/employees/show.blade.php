@extends('master')

@section('title', 'Detail Pegawai')
@section('page-title', 'Detail Pegawai')
@section('page-description', 'Informasi lengkap pegawai')

@section('content')

<div style="max-width: 1500px;">
    <div class="mb-2">
        <a href="{{ route('employees.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
    <div class="card">
        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div class="avatar avatar-lg">
                    {{ strtoupper(substr($employee->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <h2 style="margin: 0; font-size: 24px;">{{ $employee->nama_lengkap }}</h2>
                    <p style="margin: 4px 0 0 0; opacity: 0.9;">{{ $employee->email }}</p>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-accent">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="grid-2">
                <!-- Informasi Pribadi -->
                <div>
                    <h3 style="font-size: 18px; color: var(--primary-dark); margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid var(--primary);">
                        Informasi Pribadi
                    </h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <label class="text-sm text-gray">Nama Lengkap</label>
                            <p class="font-semibold">{{ $employee->nama_lengkap }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-gray">Email</label>
                            <p class="font-semibold">{{ $employee->email }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-gray">Nomor Telepon</label>
                            <p class="font-semibold">{{ $employee->nomor_telepon }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-gray">Tanggal Lahir</label>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d F Y') }}
                                <span class="text-gray">({{ \Carbon\Carbon::parse($employee->tanggal_lahir)->age }} tahun)</span>
                            </p>
                        </div>

                        <div>
                            <label class="text-sm text-gray">Alamat</label>
                            <p class="font-semibold">{{ $employee->alamat }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pekerjaan -->
                <div>
                    <h3 style="font-size: 18px; color: var(--primary-dark); margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid var(--primary);">
                        Informasi Pekerjaan
                    </h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <label class="text-sm text-gray">Departemen</label>
                            <p class="font-semibold">{{ $employee->department->nama_departemen ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-gray">Jabatan</label>
                            <p class="font-semibold">{{ $employee->position->nama_jabatan ?? '-' }}</p>
                            @if($employee->position)
                            <p class="text-sm text-success">
                                Gaji Pokok: <strong>Rp {{ number_format($employee->position->gaji_pokok, 0, ',', '.') }}</strong>
                            </p>
                            @endif
                        </div>

                        <div>
                            <label class="text-sm text-gray">Tanggal Masuk</label>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d F Y') }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-gray">Masa Kerja</label>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($employee->tanggal_masuk)->diffForHumans(['parts' => 2]) }}</p>
                        </div>

                        <div>
                            <label class="text-sm text-gray">Status Pegawai</label>
                            <div style="margin-top: 4px;">
                                @if($employee->status == 'aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($employee->status == 'nonaktif')
                                    <span class="badge badge-danger">Non-Aktif</span>
                                @else
                                    <span class="badge badge-warning">{{ ucfirst($employee->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <p class="text-sm text-gray">
                Terakhir diperbarui: {{ $employee->updated_at ? $employee->updated_at->format('d F Y, H:i') : '-' }}
            </p>
        </div>
    </div>
</div>

@endsection