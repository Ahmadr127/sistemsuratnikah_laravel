<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class KtpApiService
{
    private $baseUrl;
    private $timeout;
    private $useMockData;
    private $mockDataPath;
    private $verifySSL;

    public function __construct()
    {
        // Load from config/env for flexibility
        $this->baseUrl = rtrim(config('services.ktp_api.base_url', env('KTP_API_BASE_URL', 'https://ktp.chasouluix.biz.id/api/ktp')), '/');
        $this->timeout = (int) config('services.ktp_api.timeout', (int) env('KTP_API_TIMEOUT', 30));
        $this->useMockData = filter_var(env('KTP_USE_MOCK_DATA', false), FILTER_VALIDATE_BOOLEAN);
        $this->mockDataPath = database_path('data/ktp_mock_data.json');
        // Allow bypassing SSL verification for development (set KTP_VERIFY_SSL=false in .env)
        $this->verifySSL = filter_var(env('KTP_VERIFY_SSL', true), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Create configured HTTP client with SSL and timeout settings
     */
    private function httpClient()
    {
        $client = Http::timeout($this->timeout)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]);
        
        // Disable SSL verification if configured (for development only)
        if (!$this->verifySSL) {
            $client = $client->withoutVerifying();
        }
        
        return $client;
    }

    /**
     * Check if using mock data mode
     */
    public function isUsingMockData(): bool
    {
        return $this->useMockData;
    }

    /**
     * Load mock data from JSON file
     */
    private function loadMockData(): array
    {
        if (!File::exists($this->mockDataPath)) {
            Log::warning('Mock KTP data file not found: ' . $this->mockDataPath);
            return [];
        }

        $content = File::get($this->mockDataPath);
        $data = json_decode($content, true);
        
        return $data['data'] ?? [];
    }

    /**
     * Save mock data to JSON file
     */
    private function saveMockData(array $allData): bool
    {
        try {
            $content = json_encode([
                'success' => true,
                'message' => 'Mock KTP data untuk testing',
                'total' => count($allData),
                'data' => $allData
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            File::put($this->mockDataPath, $content);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to save mock data: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all KTP data
     */
    public function getAllKtp()
    {
        // Use mock data if enabled
        if ($this->useMockData) {
            $mockData = $this->loadMockData();
            return [
                'success' => true,
                'data' => $mockData,
                'total' => count($mockData),
                'message' => 'Data KTP (Mock Mode) berhasil diambil'
            ];
        }

        try {
            $response = $this->httpClient()->get($this->baseUrl . '/all');
            
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
        // Validate NIK format first
        if (!$this->validateNik($nik)) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Format NIK tidak valid. NIK harus berupa 16 digit angka.'
            ];
        }

        // Use mock data if enabled
        if ($this->useMockData) {
            $mockData = $this->loadMockData();
            $found = collect($mockData)->firstWhere('nik', $nik);
            
            if ($found) {
                return [
                    'success' => true,
                    'data' => $found,
                    'message' => 'Data KTP (Mock Mode) ditemukan'
                ];
            } else {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'Data KTP tidak ditemukan untuk NIK: ' . $nik
                ];
            }
        }

        try {
            $response = $this->httpClient()->get($this->baseUrl . '/nik/' . $nik);
            
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

    /**
     * Update marital status for a person by NIK
     * 
     * @param string $nik The NIK to update
     * @param string $maritalStatus The new marital status (e.g., "Kawin", "Belum Kawin")
     * @return array Response with success status and message
     */
    public function updateMaritalStatus($nik, $maritalStatus = 'Kawin')
    {
        // Validate NIK format
        if (!$this->validateNik($nik)) {
            return [
                'success' => false,
                'message' => 'Format NIK tidak valid. NIK harus berupa 16 digit angka.'
            ];
        }

        // Use mock data if enabled
        if ($this->useMockData) {
            return $this->updateMockMaritalStatus($nik, $maritalStatus);
        }

        try {
            // Prepare data to update
            $data = [
                'status_perkawinan' => $maritalStatus
            ];

            // Use the new API endpoint format: PUT /nik/{nik}/status-perkawinan
            $response = $this->httpClient()
                ->put($this->baseUrl . '/nik/' . $nik . '/status-perkawinan', $data);
            
            // If not found, try alternative endpoint
            if ($response->status() === 404 || $response->status() === 405) {
                $response = $this->httpClient()
                    ->put($this->baseUrl . '/status-perkawinan', [
                        'nik' => $nik,
                        'status_perkawinan' => $maritalStatus
                    ]);
            }

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['success']) && $responseData['success']) {
                    Log::info("KTP marital status updated for NIK: {$nik} to {$maritalStatus}");
                    return [
                        'success' => true,
                        'message' => $responseData['message'] ?? 'Status perkawinan berhasil diperbarui'
                    ];
                } else {
                    Log::warning("KTP API returned unsuccessful response for NIK: {$nik}");
                    return [
                        'success' => false,
                        'message' => $responseData['message'] ?? 'Gagal memperbarui status perkawinan'
                    ];
                }
            } else {
                Log::error("KTP API update failed for NIK: {$nik}. Status: " . $response->status());
                return [
                    'success' => false,
                    'message' => 'Gagal mengakses API KTP. Status: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error("KTP API Error - UpdateMaritalStatus for NIK {$nik}: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status perkawinan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update marital status in mock data
     */
    private function updateMockMaritalStatus($nik, $maritalStatus)
    {
        $mockData = $this->loadMockData();
        $updated = false;

        foreach ($mockData as &$item) {
            if ($item['nik'] === $nik) {
                $item['status_perkawinan'] = $maritalStatus;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $this->saveMockData($mockData);
            Log::info("Mock KTP marital status updated for NIK: {$nik} to {$maritalStatus}");
            return [
                'success' => true,
                'message' => 'Status perkawinan (Mock Mode) berhasil diperbarui menjadi ' . $maritalStatus
            ];
        }

        return [
            'success' => false,
            'message' => 'NIK tidak ditemukan dalam mock data: ' . $nik
        ];
    }

    /**
     * Reset marital status to "Belum Kawin" for testing
     */
    public function resetMaritalStatus($nik)
    {
        return $this->updateMaritalStatus($nik, 'Belum Kawin');
    }

    /**
     * Reset all mock data marital status to "Belum Kawin" (for testing)
     */
    public function resetAllMockMaritalStatus()
    {
        if (!$this->useMockData) {
            return [
                'success' => false,
                'message' => 'Fitur ini hanya tersedia dalam mock mode'
            ];
        }

        $mockData = $this->loadMockData();
        $resetCount = 0;

        foreach ($mockData as &$item) {
            if ($item['status_perkawinan'] === 'Kawin') {
                $item['status_perkawinan'] = 'Belum Kawin';
                $resetCount++;
            }
        }

        $this->saveMockData($mockData);
        
        return [
            'success' => true,
            'message' => "Berhasil reset {$resetCount} data ke status 'Belum Kawin'"
        ];
    }
}
