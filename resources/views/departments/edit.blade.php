@extends('master')

@section('title', 'Edit Departemen')
@section('page-title', 'Edit Departemen')
@section('page-description', 'Perbarui informasi departemen')

@section('content')

<div style="max-width: 600px;">
    <div class="mb-2">
        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 style="margin: 0; font-size: 18px;">Edit Departemen</h2>
            <span class="badge badge-info">ID: {{ $department->id }}</span>
        </div>

        <form action="{{ route('departments.update', $department->id) }}" method="POST">
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
                    Anda sedang mengedit: <strong>{{ $department->nama_departemen }}</strong>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Departemen <span style="color: var(--danger);">*</span></label>
                    <input type="text" name="nama_departemen" class="form-control" value="{{ old('nama_departemen', $department->nama_departemen) }}" required>
                    <span class="form-text">Masukkan nama departemen yang jelas dan deskriptif</span>
                </div>
            </div>

            <div class="card-footer">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="text-sm text-gray">
                        Terakhir diubah: {{ $department->updated_at ? $department->updated_at->format('d/m/Y H:i') : '-' }}
                    </span>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-outline">Batal</a>
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