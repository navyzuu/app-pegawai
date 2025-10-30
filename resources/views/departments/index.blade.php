@extends('master')

@section('title', 'Daftar Departemen')
@section('page-title', 'Daftar Departemen')
@section('page-description', 'Kelola departemen perusahaan')

@section('content')

<!-- Header Actions -->
<div class="flex-between mb-3">
    <div>
        <p class="text-gray">Total: <strong>{{ $departments->count() }}</strong> departemen</p>
    </div>
    <a href="{{ route('departments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Tambah Departemen
    </a>
</div>

<!-- Alert -->
@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- Grid Cards -->
<div class="stats-grid">
    @forelse($departments as $department)
    <div class="card">
        <div class="card-body">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                <div style="width: 48px; height: 48px; background-color: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 18px; color: var(--primary-dark);">{{ $department->nama_departemen }}</h3>
                    <p class="text-sm text-gray" style="margin: 4px 0 0 0;">{{ $department->employees_count }} Pegawai</p>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; padding-top: 16px; border-top: 1px solid #e0e0e0;">
                <span class="text-sm text-gray">{{ $department->employees_count }} Pegawai</span>
                <div style="display: flex; gap: 4px;">
                    <a href="{{ route('departments.show', $department->id) }}" class="btn btn-primary btn-sm">
                        Detail
                    </a>
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning btn-sm">
                        Edit
                    </a>
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-md">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card" style="grid-column: span 4;">
        <div class="card-body" style="text-align: center; padding: 48px;">
            <p class="text-gray mb-2">Belum ada departemen</p>
            <a href="{{ route('departments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Departemen Pertama
            </a>
        </div>
    </div>
    @endforelse
</div>

@endsection