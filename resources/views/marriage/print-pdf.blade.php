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
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #333;
        }

        @page {
            size: A4;
            margin: 0;
        }

        .container {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            position: relative;
            background: #fafaf8;
        }

        /* Header dengan ornamen */
        .header {
            text-align: center;
            margin-bottom: 15mm;
            padding-bottom: 10mm;
            border-bottom: 3px solid #8B0000;
            position: relative;
        }

        .header::before,
        .header::after {
            content: "✦ ❤ ✦";
            display: block;
            color: #8B0000;
            font-size: 16px;
            margin: 5px 0;
            letter-spacing: 3px;
        }

        .logo-text {
            color: #8B0000;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 3px;
        }

        .header h1 {
            font-size: 28px;
            color: #8B0000;
            font-style: italic;
            margin: 8px 0;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 11px;
            color: #666;
            margin: 3px 0;
        }

        .subtitle {
            font-size: 10px;
            color: #999;
            margin-top: 5px;
        }

        /* Content sections */
        .section {
            margin-bottom: 12mm;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #8B0000;
            text-transform: uppercase;
            border-bottom: 2px solid #8B0000;
            padding-bottom: 4px;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        /* Couple Names - Main Focus */
        .couple-names {
            text-align: center;
            background: linear-gradient(135deg, #fff5f5 0%, #fffaf9 100%);
            padding: 12mm;
            border-radius: 4px;
            margin-bottom: 10mm;
            border: 2px solid #8B0000;
        }

        .couple-names .label {
            font-size: 10px;
            color: #8B0000;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .groom-name {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 3px;
        }

        .heart {
            font-size: 20px;
            color: #8B0000;
            margin: 3px 0;
        }

        .bride-name {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 3px;
        }

        .marriage-date {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }

        /* Two column layout */
        .row {
            display: table;
            width: 100%;
            margin-bottom: 6mm;
            border-collapse: collapse;
        }

        .col {
            display: table-cell;
            width: 50%;
            padding: 6mm;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .col-full {
            display: table-cell;
            width: 100%;
            padding: 6mm;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .col-label {
            font-size: 9px;
            color: #8B0000;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }

        .col-value {
            font-size: 11px;
            color: #000;
            word-wrap: break-word;
        }

        .separator {
            margin: 8mm 0;
            border-top: 1px dashed #999;
        }

        /* Wedding Details Section */
        .wedding-details {
            background: #f9f9f9;
            padding: 8mm;
            border-left: 4px solid #8B0000;
            margin-bottom: 10mm;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6mm;
            padding-bottom: 6mm;
            border-bottom: 1px solid #eee;
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-label {
            font-size: 10px;
            color: #8B0000;
            font-weight: bold;
            text-transform: uppercase;
            width: 35%;
        }

        .detail-value {
            font-size: 11px;
            color: #000;
            width: 65%;
            text-align: right;
        }

        /* Witnesses section */
        .witnesses {
            display: table;
            width: 100%;
            margin-top: 8mm;
        }

        .witness-col {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 0 6mm;
        }

        .witness-name {
            font-size: 10px;
            color: #8B0000;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15mm;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
            height: 50px;
        }

        .signature-label {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
        }

        /* Ornamental footer */
        .footer {
            text-align: center;
            margin-top: 8mm;
            padding-top: 8mm;
            border-top: 3px solid #8B0000;
            font-size: 10px;
            color: #666;
        }

        .footer::before {
            content: "✦ ❤ ✦";
            display: block;
            color: #8B0000;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .registration-info {
            background: #fff5f5;
            padding: 6mm;
            border-radius: 2px;
            margin-top: 6mm;
            font-size: 9px;
            color: #666;
        }

        .registration-number {
            font-weight: bold;
            color: #8B0000;
        }

        /* Print specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                background: #fff;
            }
        }

        /* Decorative elements */
        .divider-ornament {
            text-align: center;
            color: #8B0000;
            font-size: 12px;
            margin: 4mm 0;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-text">KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA</div>
            <h1>BUKU NIKAH</h1>
            <p class="subtitle">Catatan Pernikahan Resmi</p>
        </div>

        <!-- Main Couple Section -->
        <div class="couple-names">
            <div class="label">Calon Pengantin Pria</div>
            <div class="groom-name">{{ $marriage->groom_name }}</div>
            
            <div class="heart">❤</div>
            
            <div class="label">Calon Pengantin Wanita</div>
            <div class="bride-name">{{ $marriage->bride_name }}</div>
            
            <div class="marriage-date">
                Akan menikah pada
                <br><strong>{{ \Carbon\Carbon::parse($marriage->marriage_date)->isoFormat('dddd, D MMMM YYYY', locale: 'id') }}</strong>
            </div>
        </div>

        <!-- Data Calon Pengantin Pria -->
        <div class="section">
            <div class="section-title">Data Calon Pengantin Pria</div>
            <div class="row">
                <div class="col">
                    <div class="col-label">Nama Lengkap</div>
                    <div class="col-value">{{ $marriage->groom_name }}</div>
                </div>
                <div class="col">
                    <div class="col-label">NIK</div>
                    <div class="col-value">{{ $marriage->groom_nik }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="col-label">Tempat Lahir</div>
                    <div class="col-value">{{ $marriage->groom_birth_place }}</div>
                </div>
                <div class="col">
                    <div class="col-label">Tanggal Lahir</div>
                    <div class="col-value">{{ \Carbon\Carbon::parse($marriage->groom_birth_date)->isoFormat('D MMMM YYYY', locale: 'id') }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-full">
                    <div class="col-label">Alamat</div>
                    <div class="col-value">{{ $marriage->groom_address }}</div>
                </div>
            </div>
        </div>

        <div class="divider-ornament">✦ ❤ ✦</div>

        <!-- Data Calon Pengantin Wanita -->
        <div class="section">
            <div class="section-title">Data Calon Pengantin Wanita</div>
            <div class="row">
                <div class="col">
                    <div class="col-label">Nama Lengkap</div>
                    <div class="col-value">{{ $marriage->bride_name }}</div>
                </div>
                <div class="col">
                    <div class="col-label">NIK</div>
                    <div class="col-value">{{ $marriage->bride_nik }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="col-label">Tempat Lahir</div>
                    <div class="col-value">{{ $marriage->bride_birth_place }}</div>
                </div>
                <div class="col">
                    <div class="col-label">Tanggal Lahir</div>
                    <div class="col-value">{{ \Carbon\Carbon::parse($marriage->bride_birth_date)->isoFormat('D MMMM YYYY', locale: 'id') }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-full">
                    <div class="col-label">Alamat</div>
                    <div class="col-value">{{ $marriage->bride_address }}</div>
                </div>
            </div>
        </div>

        <div class="divider-ornament">✦ ❤ ✦</div>

        <!-- Wedding Details -->
        <div class="section wedding-details">
            <div class="section-title">Detail Pernikahan</div>
            
            <div class="detail-row">
                <div class="detail-label">Tanggal Pernikahan</div>
                <div class="detail-value"><strong>{{ \Carbon\Carbon::parse($marriage->marriage_date)->isoFormat('D MMMM YYYY', locale: 'id') }}</strong></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Tempat Pernikahan</div>
                <div class="detail-value">{{ $marriage->marriage_place }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Saksi 1</div>
                <div class="detail-value">{{ $marriage->witness1_name }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Saksi 2</div>
                <div class="detail-value">{{ $marriage->witness2_name }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Status Pengajuan</div>
                <div class="detail-value">
                    <strong>
                        @if($marriage->status === 'active')
                            AKTIF ✓
                        @elseif($marriage->status === 'inactive')
                            NONAKTIF
                        @elseif($marriage->status === 'cancelled')
                            DIBATALKAN
                        @else
                            {{ strtoupper($marriage->status) }}
                        @endif
                    </strong>
                </div>
            </div>
        </div>

        <!-- Witnesses Signatures -->
        <div class="section">
            <div class="section-title">Tanda Tangan Saksi & Petugas</div>
            
            <div class="witnesses">
                <div class="witness-col">
                    <div class="witness-name">Saksi 1</div>
                    <div class="signature-line"></div>
                    <div class="signature-label">{{ $marriage->witness1_name }}</div>
                </div>
                <div class="witness-col">
                    <div class="witness-name">Saksi 2</div>
                    <div class="signature-line"></div>
                    <div class="signature-label">{{ $marriage->witness2_name }}</div>
                </div>
            </div>

            <div class="witnesses" style="margin-top: 15mm;">
                <div class="witness-col">
                    <div class="witness-name">Calon Pengantin Pria</div>
                    <div class="signature-line"></div>
                    <div class="signature-label">{{ $marriage->groom_name }}</div>
                </div>
                <div class="witness-col">
                    <div class="witness-name">Calon Pengantin Wanita</div>
                    <div class="signature-line"></div>
                    <div class="signature-label">{{ $marriage->bride_name }}</div>
                </div>
            </div>

            <div class="witnesses" style="margin-top: 15mm;">
                <div class="witness-col" style="width: 100%; padding: 0;">
                    <div class="witness-name">Petugas Pencatat Pernikahan</div>
                    <div class="signature-line"></div>
                    <div class="signature-label">Tanda Tangan & Tanggal</div>
                </div>
            </div>
        </div>

        <!-- Registration Info -->
        <div class="registration-info">
            <div style="margin-bottom: 3px;">
                <strong>Nomor Pengajuan:</strong> <span class="registration-number">#{{ str_pad($marriage->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div style="margin-bottom: 3px;">
                <strong>Tanggal Pengajuan:</strong> {{ $marriage->created_at->isoFormat('D MMMM YYYY', locale: 'id') }}
            </div>
            <div>
                <strong>Status:</strong> {{ ucfirst($marriage->status) }} (Belum Resmi Terdaftar)
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div>Dokumen ini adalah bukti pengajuan pernikahan yang telah terdaftar dalam sistem</div>
            <div style="margin-top: 2mm; font-size: 8px;">
                Dicetak pada {{ now()->isoFormat('D MMMM YYYY [pukul] HH:mm:ss', locale: 'id') }}
            </div>
        </div>
    </div>
</body>
</html>
