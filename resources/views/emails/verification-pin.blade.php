<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f6f8fa; margin:0; padding:24px;">
    <div style="max-width:560px; margin:0 auto; background:#ffffff; border-radius:12px; padding:24px; border:1px solid #eef2f7;">
        <h2 style="margin-top:0; color:#111827;">Kode Verifikasi</h2>
        <p style="color:#374151;">
            Berikut adalah kode verifikasi {{ $purpose === 'register' ? 'pendaftaran' : 'reset password' }} Anda.
        </p>
        <div style="font-size:32px; letter-spacing:8px; text-align:center; font-weight:bold; color:#111827; padding:16px 0;">
            {{ $pin }}
        </div>
        <p style="color:#374151;">Kode ini berlaku selama 10 menit. Jangan bagikan kode ini kepada siapa pun.</p>
        <p style="color:#6b7280; font-size:12px;">Email ini dikirim otomatis oleh sistem. Abaikan jika Anda tidak merasa melakukan permintaan ini.</p>
    </div>
</body>
</html>
