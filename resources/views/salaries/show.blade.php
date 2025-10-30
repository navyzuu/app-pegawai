@extends('master')

@section('title', 'Detail Gaji')
@section('page-title', 'Detail Slip Gaji')
@section('page-description', 'Informasi detail gaji pegawai')

@section('content')
<div class="container">
    <div class="content-wrapper">
        <div class="mb-2">
            <a href="{{ route('salaries.index') }}" class="btn btn-outline btn-sm">
                ← Kembali ke Daftar Gaji
            </a>
        </div>
        <div class="card" id="salary-slip">
            <div class="card-header">
                <div>
                    <h2 style="margin: 0; font-size: 24px;">Slip Gaji</h2>
                    <p style="margin: 4px 0 0 0; font-size: 14px; opacity: 0.9;">
                        Periode: {{ $salary->bulan }}
                    </p>
                </div>
                <div class="flex flex-gap-1 no-print">
                    <a href="{{ route('salaries.edit', $salary->id) }}"
                        class="btn btn-accent btn-sm">
                        Edit
                    </a>
                    <button onclick="window.print()"
                        class="btn btn-success btn-sm">
                        Print
                    </button>
                    <form action="{{ route('salaries.destroy', $salary->id) }}"
                        method="POST"
                        style="display: inline;"
                        onsubmit="return confirm('Yakin ingin menghapus data gaji ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 2px solid #e0e0e0;">
                    <div class="flex" style="align-items: center; gap: 16px; margin-bottom: 16px;">
                        <div class="avatar avatar-lg">
                            {{ strtoupper(substr($salary->employee->nama_lengkap, 0, 1)) }}
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 28px; font-weight: 700; color: var(--primary-dark);">
                                {{ $salary->employee->nama_lengkap }}
                            </h3>
                            <p style="margin: 4px 0 0 0; font-size: 16px; color: #6b7280;">
                                {{ $salary->employee->position->nama_jabatan ?? '-' }}
                            </p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; color: #9ca3af;">
                                {{ $salary->employee->department->nama_departemen ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 600; color: var(--primary-dark);">
                        Rincian Gaji
                    </h4>
                    <div class="flex-between" style="padding: 16px 0; border-bottom: 1px solid #f0f0f0;">
                        <div>
                            <p style="margin: 0; font-weight: 500; font-size: 15px; color: #374151;">
                                Gaji Pokok
                            </p>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #9ca3af;">
                                Basic Salary
                            </p>
                        </div>
                        <p style="margin: 0; font-size: 18px; font-weight: 600; color: #1f2937;">
                            Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="flex-between" style="padding: 16px 0; border-bottom: 1px solid #f0f0f0;">
                        <div>
                            <p style="margin: 0; font-weight: 500; font-size: 15px; color: #374151;">
                                Tunjangan
                            </p>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #9ca3af;">
                                Allowance
                            </p>
                        </div>
                        <p style="margin: 0; font-size: 18px; font-weight: 600; color: var(--success);">
                            + Rp {{ number_format($salary->tunjangan, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="flex-between" style="padding: 16px 0; border-bottom: 1px solid #f0f0f0;">
                        <div>
                            <p style="margin: 0; font-weight: 500; font-size: 15px; color: #374151;">
                                Potongan
                            </p>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #9ca3af;">
                                Deduction
                            </p>
                        </div>
                        <p style="margin: 0; font-size: 18px; font-weight: 600; color: var(--danger);">
                            - Rp {{ number_format($salary->potongan, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="flex-between" style="padding: 20px; background-color: #f0f3ff; border-radius: 4px; margin-top: 16px; border-left: 4px solid var(--primary);">
                        <div>
                            <p style="margin: 0; font-size: 18px; font-weight: 700; color: var(--primary-dark);">
                                Total Gaji Diterima
                            </p>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #6b7280;">
                                Net Salary
                            </p>
                        </div>
                        <p style="margin: 0; font-size: 32px; font-weight: 700; color: var(--primary);">
                            Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <div style="margin-top: 24px; padding: 16px; background-color: #f9fafb; border-radius: 4px; border: 1px solid #e5e7eb;">
                    <p style="margin: 0; font-size: 13px; color: #6b7280; line-height: 1.6;">
                        <strong style="color: #374151;">Perhitungan:</strong>
                        Gaji Pokok (Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }})
                        + Tunjangan (Rp {{ number_format($salary->tunjangan, 0, ',', '.') }})
                        - Potongan (Rp {{ number_format($salary->potongan, 0, ',', '.') }})
                        = <strong style="color: var(--primary);">Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}</strong>
                    </p>
                </div>
            </div>
            <div class="card-footer" style="text-align: right;">
                <p style="margin: 0 0 4px 0; font-size: 13px; color: #6b7280;">
                    Dibuat: {{ $salary->created_at->format('d F Y, H:i') }}
                </p>
                <p style="margin: 0; font-size: 13px; color: #6b7280;">
                    Terakhir diperbarui: {{ $salary->updated_at->format('d F Y, H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #salary-slip,
        #salary-slip * {
            visibility: visible;
        }

        #salary-slip {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .no-print {
            display: none !important;
        }

        .card-header {
            background-color: var(--primary) !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

@endsection