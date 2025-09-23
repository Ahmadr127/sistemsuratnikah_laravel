<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KtpApiService
{
    private $baseUrl;
    private $timeout;

    public function __construct()
    {
        $this->baseUrl = 'https://ktp.chasouluix.biz.id/api/ktp';
        $this->timeout = 30;
    }

    /**
     * Get all KTP data
     */
    public function getAllKtp()
    {
        try {
            $response = Http::timeout($this->timeout)->get($this->baseUrl . '/all');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    return [
                        'success' => true,
                        'data' => $data['data'] ?? [],
                        'total' => $data['total'] ?? 0,
                        'message' => $data['message'] ?? 'Data KTP berhasil diambil'
                    ];
                } else {
                    return [
                        'success' => false,
                        'data' => [],
                        'total' => 0,
                        'message' => $data['message'] ?? 'Gagal mengambil data KTP'
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'data' => [],
                    'total' => 0,
                    'message' => 'Gagal mengakses API KTP. Status: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error('KTP API Error - GetAll: ' . $e->getMessage());
            return [
                'success' => false,
                'data' => [],
                'total' => 0,
                'message' => 'Terjadi kesalahan saat mengakses API KTP: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get KTP data by NIK
     */
    public function getKtpByNik($nik)
    {
        try {
            // Validate NIK format
            if (!$this->validateNik($nik)) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'Format NIK tidak valid. NIK harus berupa 16 digit angka.'
                ];
            }

            $response = Http::timeout($this->timeout)->get($this->baseUrl . '/nik/' . $nik);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['success']) {
                    return [
                        'success' => true,
                        'data' => $data['data'],
                        'message' => $data['message']
                    ];
                } else {
                    return [
                        'success' => false,
                        'data' => null,
                        'message' => $data['message'] ?? 'Data KTP tidak ditemukan'
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'Gagal mengakses API KTP. Status: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error('KTP API Error - GetByNik: ' . $e->getMessage());
            return [
                'success' => false,
                'data' => null,
                'message' => 'Terjadi kesalahan saat mengakses API KTP: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Validate NIK format
     */
    private function validateNik($nik)
    {
        // NIK should be 16 digits
        return preg_match('/^\d{16}$/', $nik);
    }

    /**
     * Check if KTP data is valid for marriage
     */
    public function validateKtpForMarriage($ktpData)
    {
        if (!$ktpData) {
            return [
                'valid' => false,
                'message' => 'Data KTP tidak ditemukan'
            ];
        }

        // Check if KTP status is completed
        if ($ktpData['status'] !== 'selesai') {
            return [
                'valid' => false,
                'message' => 'Status KTP belum selesai. Status saat ini: ' . $ktpData['status']
            ];
        }

        // Check if marriage status is appropriate
        if ($ktpData['status_perkawinan'] === 'Kawin') {
            return [
                'valid' => false,
                'message' => 'Orang tersebut sudah menikah'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Data KTP valid untuk pernikahan'
        ];
    }

    /**
     * Format KTP data for marriage form
     */
    public function formatKtpForMarriage($ktpData)
    {
        return [
            'nik' => $ktpData['nik'],
            'name' => $ktpData['nama_lengkap'],
            'birth_date' => $ktpData['tanggal_lahir'],
            'birth_place' => $ktpData['tempat_lahir'],
            'address' => $ktpData['alamat'],
            'gender' => $ktpData['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan',
            'religion' => $ktpData['agama'],
            'marital_status' => $ktpData['status_perkawinan'],
            'occupation' => $ktpData['pekerjaan'],
            'phone' => $ktpData['no_telepon'],
            'province' => $ktpData['provinsi'],
            'city' => $ktpData['kabupaten'],
            'district' => $ktpData['kecamatan'],
            'village' => $ktpData['kelurahan'],
            'rt' => $ktpData['rt'],
            'rw' => $ktpData['rw'],
            'postal_code' => $ktpData['kode_pos'],
            'blood_type' => $ktpData['golongan_darah'],
            'nationality' => $ktpData['kewarganegaraan'],
            'ktp_status' => $ktpData['status'],
            'submission_date' => $ktpData['tanggal_pengajuan'],
            'completion_date' => $ktpData['tanggal_selesai'],
        ];
    }
}
