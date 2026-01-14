<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';

    protected $fillable = [
        'kode_qr',
        'pemegang',
        'nip',
        'jabatan',
        'unit_kerja',
        'nama_kendaraan',
        'no_polisi',
        'thn_kendaraan',
        'no_rangka',
        'no_mesin',
        'pajak',
        'jenis',
    ];

    public function getPajakBulanAttribute(): ?int
    {
        if (!is_string($this->pajak)) {
            return null;
        }

        if (!preg_match('/^(\d{4})-(\d{2})$/', $this->pajak, $m)) {
            return null;
        }

        return (int) $m[2];
    }

    public function getPajakTahunAttribute(): ?int
    {
        if (!is_string($this->pajak)) {
            return null;
        }

        if (!preg_match('/^(\d{4})-(\d{2})$/', $this->pajak, $m)) {
            return null;
        }

        return (int) $m[1];
    }

    public function getPajakLabelAttribute(): string
    {
        if (!is_string($this->pajak)) {
            return '-';
        }

        if (!preg_match('/^(\d{4})-(\d{2})$/', $this->pajak, $m)) {
            return $this->pajak;
        }

        return $m[2] . '/' . $m[1];
    }

    public function getPajakIsActiveAttribute(): bool
    {
        if (!is_string($this->pajak)) {
            return false;
        }

        try {
            $expiry = Carbon::createFromFormat('Y-m', $this->pajak)->endOfMonth();
        } catch (\Throwable $e) {
            return false;
        }

        return now()->lessThanOrEqualTo($expiry);
    }
}
