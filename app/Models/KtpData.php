<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KtpData extends Model
{
    protected $fillable = [
        'ktp_id',
        'user_id',
        'no_pengajuan',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'rt',
        'rw',
        'kode_pos',
        'no_telepon',
        'akta_kelahiran_path',
        'kartu_keluarga_path',
        'pas_foto_path',
        'status',
        'catatan',
        'tanggal_pengajuan',
        'tanggal_selesai',
        'user_name',
        'user_email',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pengajuan' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    /**
     * Check if KTP is completed and ready for marriage
     */
    public function isReadyForMarriage(): bool
    {
        return $this->status === 'selesai' && 
               $this->status_perkawinan !== 'Kawin';
    }

    /**
     * Get formatted name with gender prefix
     */
    public function getFormattedNameAttribute(): string
    {
        $prefix = $this->jenis_kelamin === 'L' ? 'Bapak' : 'Ibu';
        return $prefix . ' ' . $this->nama_lengkap;
    }

    /**
     * Get full address
     */
    public function getFullAddressAttribute(): string
    {
        return $this->alamat . ', RT ' . $this->rt . '/RW ' . $this->rw . 
               ', ' . $this->kelurahan . ', ' . $this->kecamatan . 
               ', ' . $this->kabupaten . ', ' . $this->provinsi . 
               ' ' . $this->kode_pos;
    }

    /**
     * Get age from birth date
     */
    public function getAgeAttribute(): int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : 0;
    }

    /**
     * Check if person is eligible for marriage (minimum age 19)
     */
    public function isEligibleForMarriage(): bool
    {
        return $this->age >= 19;
    }
}
