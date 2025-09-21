<?php

return [
    'title' => env('HOME_TITLE', 'Sistem Buku Nikah Digital'),
    'subtitle' => env('HOME_SUBTITLE', 'Mudah, Cepat, dan Terpercaya'),

    // Daftar fitur pada section "Fitur Unggulan"
    'features' => [
        [
            'icon' => 'fas fa-certificate',
            'title' => 'Buku Nikah Digital',
            'description' => 'Buat buku nikah secara digital dengan mudah dan cepat',
        ],
        [
            'icon' => 'fas fa-search',
            'title' => 'Verifikasi NIK',
            'description' => 'Verifikasi data calon pengantin melalui NIK secara real-time',
        ],
        [
            'icon' => 'fas fa-shield-alt',
            'title' => 'Keamanan Data',
            'description' => 'Data Anda aman dan terlindungi dengan enkripsi terbaik',
        ],
        [
            'icon' => 'fas fa-clock',
            'title' => 'Proses Cepat',
            'description' => 'Proses pembuatan buku nikah hanya dalam hitungan menit',
        ],
    ],

    // Angka pada section "Pencapaian Kami"
    'stats' => [
        'total_marriages' => (int) env('HOME_TOTAL_MARRIAGES', 1250),
        'happy_couples' => (int) env('HOME_HAPPY_COUPLES', 2500),
        'years_experience' => (int) env('HOME_YEARS_EXPERIENCE', 5),
        'satisfaction_rate' => (int) env('HOME_SATISFACTION_RATE', 98),
    ],
];


