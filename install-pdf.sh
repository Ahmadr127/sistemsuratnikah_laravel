#!/bin/bash

# =============================================================================
# Script Installation DomPDF untuk Fitur Print Buku Nikah
# =============================================================================

echo "╔════════════════════════════════════════════════════════════════════╗"
echo "║  SETUP PRINT PDF BUKU NIKAH - SISTEM SURAT NIKAH LARAVEL         ║"
echo "╚════════════════════════════════════════════════════════════════════╝"
echo ""

# Step 1: Check if composer exists
echo "📦 Step 1: Checking Composer..."
if ! command -v composer &> /dev/null; then
    echo "❌ Composer tidak ditemukan. Silakan install Composer terlebih dahulu."
    echo "   Visit: https://getcomposer.org/"
    exit 1
fi
echo "✅ Composer ditemukan!"
echo ""

# Step 2: Install DomPDF
echo "📦 Step 2: Installing barryvdh/laravel-dompdf..."
composer require barryvdh/laravel-dompdf

if [ $? -eq 0 ]; then
    echo "✅ DomPDF berhasil diinstall!"
else
    echo "❌ Gagal menginstall DomPDF. Silakan cek error message di atas."
    exit 1
fi
echo ""

# Step 3: Publish config (optional)
echo "📦 Step 3: Publishing DomPDF configuration..."
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider" --force

if [ $? -eq 0 ]; then
    echo "✅ Konfigurasi DomPDF berhasil dipublish!"
else
    echo "⚠️  Gagal mempublish config (optional, tidak fatal)"
fi
echo ""

# Step 4: Clear cache
echo "🔄 Step 4: Clearing Laravel cache..."
php artisan config:clear
php artisan cache:clear
echo "✅ Cache cleared!"
echo ""

# Step 5: Summary
echo "╔════════════════════════════════════════════════════════════════════╗"
echo "║                     ✅ SETUP SELESAI!                             ║"
echo "╚════════════════════════════════════════════════════════════════════╝"
echo ""
echo "📋 Files yang sudah ditambah:"
echo "   ✅ app/Http/Controllers/MarriageController.php (method: printPdf)"
echo "   ✅ routes/web.php (route: /marriage/print/{id})"
echo "   ✅ resources/views/marriage/print-pdf.blade.php (template)"
echo "   ✅ resources/views/marriage/status.blade.php (print button)"
echo ""
echo "🎯 Cara Menggunakan:"
echo "   1. Pastikan sudah login sebagai user"
echo "   2. Pergi ke /marriage/status"
echo "   3. Klik tombol 'Print' untuk generate PDF buku nikah"
echo "   4. PDF akan dibuka di tab baru (bisa di-download atau langsung print)"
echo ""
echo "📚 Dokumentasi:"
echo "   Lihat file: SETUP_PRINT_PDF.md"
echo ""
echo "💡 Tips:"
echo "   - DomPDF mungkin lambat first time (250-500ms)"
echo "   - Untuk customize design, edit: resources/views/marriage/print-pdf.blade.php"
echo "   - Warna default: Maroon (#8B0000)"
echo ""
echo "🔗 Resources:"
echo "   - DomPDF: https://github.com/barryvdh/laravel-dompdf"
echo "   - CSS Support: https://dompdf.github.io/"
echo ""
