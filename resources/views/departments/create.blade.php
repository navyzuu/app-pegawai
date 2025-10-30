@extends('master')

@section('title', 'Tambah Departemen')
@section('page-title', 'Tambah Departemen Baru')
@section('page-description', 'Isi formulir untuk menambahkan departemen')

@section('content')

<div style="max-width: 600px;">
    <div class="mb-2">
        <a href="{{ route('departments.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 style="margin: 0; font-size: 18px;">Form Departemen Baru</h2>
        </div>

        <form action="{{ route('departments.store') }}" method="POST">
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

                <div class="form-group">
                    <label class="form-label">Nama Departemen <span style="color: var(--danger);">*</span></label>
                    <input type="text" name="nama_departemen" class="form-control" value="{{ old('nama_departemen') }}" placeholder="Contoh: IT & Technology" required>
                    <span class="form-text">Masukkan nama departemen yang jelas dan deskriptif</span>
                </div>
            </div>

            <div class="card-footer">
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                    <a href="{{ route('departments.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection