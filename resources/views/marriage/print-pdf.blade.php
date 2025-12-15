<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Nikah - {{ $marriage->groom_name }} & {{ $marriage->bride_name }}</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Georgia', 'Times New Roman', serif;
        line-height: 1.4;
        color: #2c3e50;
        background: #fff;
    }

    @page {
        size: A4;
        margin: 0;
    }

    .page {
        width: 210mm;
        height: 297mm;
        padding: 0;
        position: relative;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f8f9fa 100%);
    }

    /* Decorative Border */
    .page::before {
        content: '';
        position: absolute;
        top: 6mm;
        left: 6mm;
        right: 6mm;
        bottom: 6mm;
        border: 3px solid #1e3a8a;
        border-radius: 4px;
        pointer-events: none;
    }

    .page::after {
        content: '';
        position: absolute;
        top: 8mm;
        left: 8mm;
        right: 8mm;
        bottom: 8mm;
        border: 1px solid #d4af37;
        border-radius: 2px;
        pointer-events: none;
    }

    .container {
        padding: 14mm 16mm;
        position: relative;
        z-index: 1;
    }

    /* Compact Premium Header */
    .header {
        text-align: center;
        margin-bottom: 6mm;
        padding: 5mm 0;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 6px;
        position: relative;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
    }

    .header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #d4af37 0%, #ffd700 50%, #d4af37 100%);
        border-radius: 6px 6px 0 0;
    }

    .seal-icon {
        display: inline-block;
        width: 35px;
        height: 35px;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid #d4af37;
        border-radius: 50%;
        margin-bottom: 2mm;
        line-height: 31px;
        font-size: 18px;
        color: #d4af37;
        font-weight: bold;
    }

    .header .country {
        color: #d4af37;
        font-size: 8px;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 1mm;
    }

    .header h1 {
        font-size: 24px;
        color: #fff;
        font-weight: 700;
        margin: 1mm 0;
        letter-spacing: 3px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .header .subtitle {
        font-size: 9px;
        color: rgba(255, 255, 255, 0.9);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-weight: 500;
    }

    /* Compact Couple Section */
    .couple-section {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        padding: 6mm;
        border-radius: 8px;
        margin-bottom: 5mm;
        border: 2px solid #1e3a8a;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
    }

    .couple-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #1e3a8a 0%, #d4af37 50%, #1e3a8a 100%);
    }

    .couple-label {
        font-size: 8px;
        color: #1e3a8a;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        margin-bottom: 1mm;
    }

    .couple-name {
        font-size: 16px;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 1mm;
        text-align: center;
    }

    .heart-divider {
        text-align: center;
        font-size: 18px;
        color: #d4af37;
        margin: 2mm 0;
    }

    .wedding-date-box {
        text-align: center;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 3mm;
        border-radius: 6px;
        margin-top: 3mm;
        box-shadow: 0 3px 6px rgba(30, 58, 138, 0.3);
    }

    .wedding-date-box .label {
        font-size: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.9;
        margin-bottom: 1mm;
    }

    .wedding-date-box .date {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* Compact Card Sections */
    .info-card {
        background: #ffffff;
        border-radius: 6px;
        padding: 4mm;
        margin-bottom: 4mm;
        border-left: 3px solid #1e3a8a;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        page-break-inside: avoid;
    }

    .card-title {
        font-size: 10px;
        font-weight: 700;
        color: #1e3a8a;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 3mm;
        padding-bottom: 1.5mm;
        border-bottom: 1.5px solid #e5e7eb;
        display: flex;
        align-items: center;
    }

    .card-title::before {
        content: '';
        display: inline-block;
        width: 3px;
        height: 12px;
        background: #d4af37;
        margin-right: 2mm;
    }

    /* Data Grid - More Compact */
    .data-grid {
        display: table;
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .data-row {
        display: table-row;
    }

    .data-cell {
        display: table-cell;
        padding: 2mm;
        border-bottom: 1px solid #f3f4f6;
    }

    .data-cell.full {
        width: 100%;
    }

    .data-cell.half {
        width: 50%;
    }

    .field-label {
        font-size: 8px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-weight: 600;
        margin-bottom: 0.5mm;
    }

    .field-value {
        font-size: 10px;
        color: #1e293b;
        font-weight: 500;
    }

    /* Wedding Details - Horizontal Compact Layout */
    .wedding-details {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border: 2px solid #d4af37;
        border-radius: 6px;
        padding: 4mm;
        margin-bottom: 4mm;
        box-shadow: 0 3px 8px rgba(212, 175, 55, 0.12);
        page-break-inside: avoid;
    }

    .details-grid {
        display: table;
        width: 100%;
        border-collapse: collapse;
    }

    .details-row {
        display: table-row;
    }

    .detail-cell {
        display: table-cell;
        width: 50%;
        padding: 2mm;
        vertical-align: top;
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-cell.full {
        width: 100%;
    }

    .detail-label {
        font-size: 8px;
        color: #1e3a8a;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5mm;
    }

    .detail-value {
        font-size: 10px;
        color: #1e293b;
        font-weight: 500;
    }

    .status-badge {
        display: inline-block;
        padding: 1.5mm 3mm;
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        border-radius: 12px;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 2px 4px rgba(34, 197, 94, 0.3);
    }

    /* Compact Signature Section */
    .signature-section {
        margin-top: 4mm;
        page-break-inside: avoid;
    }

    .signature-grid {
        display: table;
        width: 100%;
        margin-top: 3mm;
    }

    .signature-row {
        display: table-row;
    }

    .signature-cell {
        display: table-cell;
        width: 50%;
        text-align: center;
        padding: 0 2mm;
        vertical-align: top;
    }

    .signature-cell.full {
        width: 100%;
    }

    .sig-title {
        font-size: 8px;
        color: #1e3a8a;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8mm;
    }

    .sig-line {
        width: 70%;
        margin: 0 auto;
        height: 30px;
        border-bottom: 1.5px solid #1e3a8a;
    }

    .sig-name {
        font-size: 8px;
        color: #64748b;
        margin-top: 1.5mm;
        font-weight: 500;
    }

    /* Compact Registration Box */
    .registration-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 2px solid #d4af37;
        border-radius: 6px;
        padding: 3mm;
        margin-top: 4mm;
        font-size: 8px;
        color: #78350f;
    }

    .reg-row {
        margin-bottom: 1.5mm;
        display: flex;
        align-items: center;
    }

    .reg-row:last-child {
        margin-bottom: 0;
    }

    .reg-label {
        font-weight: 700;
        margin-right: 1.5mm;
    }

    .reg-number {
        font-weight: 700;
        color: #92400e;
        font-size: 10px;
    }

    /* Compact Footer */
    .footer {
        text-align: center;
        margin-top: 4mm;
        padding-top: 3mm;
        border-top: 1.5px solid #1e3a8a;
        font-size: 8px;
        color: #64748b;
    }

    .footer-note {
        margin-bottom: 1mm;
        font-style: italic;
    }

    .print-time {
        font-size: 7px;
        color: #94a3b8;
    }

    /* Decorative Elements */
    .ornament {
        text-align: center;
        color: #d4af37;
        font-size: 12px;
        margin: 3mm 0;
        letter-spacing: 3px;
    }

    /* Print Optimizations */
    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        .page {
            background: #fff;
        }
    }
    </style>
</head>

<body>
    <div class="page">
        <div class="container">
            <!-- Compact Header -->
            <div class="header">
                <div class="seal-icon">⚜</div>
                <div class="country">Republik Indonesia</div>
                <h1>BUKU NIKAH</h1>
                <div class="subtitle">Catatan Pernikahan Resmi</div>
            </div>

            <!-- Compact Couple Section -->
            <div class="couple-section">
                <div class="couple-label">Calon Pengantin Pria</div>
                <div class="couple-name">{{ $marriage->groom_name }}</div>

                <div class="heart-divider">♥</div>

                <div class="couple-label">Calon Pengantin Wanita</div>
                <div class="couple-name">{{ $marriage->bride_name }}</div>

                <div class="wedding-date-box">
                    <div class="label">Tanggal Pernikahan</div>
                    <div class="date">{{ \Carbon\Carbon::parse($marriage->marriage_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</div>
                </div>
            </div>

            <!-- Groom Information - Compact -->
            <div class="info-card">
                <div class="card-title">Data Calon Pengantin Pria</div>
                
                <div class="data-grid">
                    <div class="data-row">
                        <div class="data-cell half">
                            <div class="field-label">Nama Lengkap</div>
                            <div class="field-value">{{ $marriage->groom_name }}</div>
                        </div>
                        <div class="data-cell half">
                            <div class="field-label">NIK</div>
                            <div class="field-value">{{ $marriage->groom_nik }}</div>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell half">
                            <div class="field-label">Tempat Lahir</div>
                            <div class="field-value">{{ $marriage->groom_birth_place }}</div>
                        </div>
                        <div class="data-cell half">
                            <div class="field-label">Tanggal Lahir</div>
                            <div class="field-value">{{ \Carbon\Carbon::parse($marriage->groom_birth_date)->locale('id')->isoFormat('D MMMM YYYY') }}</div>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell full">
                            <div class="field-label">Alamat Lengkap</div>
                            <div class="field-value">{{ $marriage->groom_address }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ornament">❖ ♥ ❖</div>

            <!-- Bride Information - Compact -->
            <div class="info-card">
                <div class="card-title">Data Calon Pengantin Wanita</div>
                
                <div class="data-grid">
                    <div class="data-row">
                        <div class="data-cell half">
                            <div class="field-label">Nama Lengkap</div>
                            <div class="field-value">{{ $marriage->bride_name }}</div>
                        </div>
                        <div class="data-cell half">
                            <div class="field-label">NIK</div>
                            <div class="field-value">{{ $marriage->bride_nik }}</div>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell half">
                            <div class="field-label">Tempat Lahir</div>
                            <div class="field-value">{{ $marriage->bride_birth_place }}</div>
                        </div>
                        <div class="data-cell half">
                            <div class="field-label">Tanggal Lahir</div>
                            <div class="field-value">{{ \Carbon\Carbon::parse($marriage->bride_birth_date)->locale('id')->isoFormat('D MMMM YYYY') }}</div>
                        </div>
                    </div>
                    <div class="data-row">
                        <div class="data-cell full">
                            <div class="field-label">Alamat Lengkap</div>
                            <div class="field-value">{{ $marriage->bride_address }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ornament">❖ ♥ ❖</div>

            <!-- Wedding Details - Compact Horizontal Layout -->
            <div class="wedding-details">
                <div class="card-title">Informasi Pernikahan</div>
                
                <div class="details-grid">
                    <div class="details-row">
                        <div class="detail-cell">
                            <div class="detail-label">Tanggal Akad</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($marriage->marriage_date)->locale('id')->isoFormat('D MMMM YYYY') }}</div>
                        </div>
                        <div class="detail-cell">
                            <div class="detail-label">Tempat Akad</div>
                            <div class="detail-value">{{ $marriage->marriage_place }}</div>
                        </div>
                    </div>
                    <div class="details-row">
                        <div class="detail-cell">
                            <div class="detail-label">Saksi Pertama</div>
                            <div class="detail-value">{{ $marriage->witness1_name }}</div>
                        </div>
                        <div class="detail-cell">
                            <div class="detail-label">Saksi Kedua</div>
                            <div class="detail-value">{{ $marriage->witness2_name }}</div>
                        </div>
                    </div>
                    <div class="details-row">
                        <div class="detail-cell full" style="border-bottom: none;">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                <span class="status-badge">
                                    @if($marriage->status === 'active')
                                    ✓ AKTIF
                                    @else
                                    {{ strtoupper($marriage->status) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compact Signatures Section -->
            <div class="info-card signature-section">
                <div class="card-title">Tanda Tangan & Persetujuan</div>

                <!-- Witnesses -->
                <div class="signature-grid">
                    <div class="signature-row">
                        <div class="signature-cell">
                            <div class="sig-title">Saksi I</div>
                            <div class="sig-line"></div>
                            <div class="sig-name">{{ $marriage->witness1_name }}</div>
                        </div>
                        <div class="signature-cell">
                            <div class="sig-title">Saksi II</div>
                            <div class="sig-line"></div>
                            <div class="sig-name">{{ $marriage->witness2_name }}</div>
                        </div>
                    </div>
                </div>

                <!-- Couple Signatures -->
                <div class="signature-grid" style="margin-top: 4mm;">
                    <div class="signature-row">
                        <div class="signature-cell">
                            <div class="sig-title">Pengantin Pria</div>
                            <div class="sig-line"></div>
                            <div class="sig-name">{{ $marriage->groom_name }}</div>
                        </div>
                        <div class="signature-cell">
                            <div class="sig-title">Pengantin Wanita</div>
                            <div class="sig-line"></div>
                            <div class="sig-name">{{ $marriage->bride_name }}</div>
                        </div>
                    </div>
                </div>

                <!-- Officer Signature -->
                <div class="signature-grid" style="margin-top: 4mm;">
                    <div class="signature-row">
                        <div class="signature-cell full">
                            <div class="sig-title">Petugas Pencatat Nikah</div>
                            <div class="sig-line" style="width: 35%;"></div>
                            <div class="sig-name">Tanda Tangan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compact Registration Info -->
            <div class="registration-box">
                <div class="reg-row">
                    <span class="reg-label">No. Registrasi:</span>
                    <span class="reg-number">#{{ str_pad($marriage->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="reg-row">
                    <span class="reg-label">Tgl. Pengajuan:</span>
                    <span>{{ $marriage->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                </div>
                <div class="reg-row">
                    <span class="reg-label">Catatan:</span>
                    <span>Bukti pengajuan pernikahan terdaftar dalam sistem</span>
                </div>
            </div>

            <!-- Compact Footer -->
            <div class="footer">
                <div class="footer-note">Dokumen bukti pengajuan pernikahan resmi</div>
                <div class="print-time">Dicetak {{ now()->locale('id')->isoFormat('D MMM YYYY, HH:mm') }} WIB</div>
            </div>
        </div>
    </div>
</body>

</html>