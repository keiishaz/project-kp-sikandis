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

        // Handle full date format (Y-m-d) -> display as d/m/Y
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $this->pajak, $m)) {
            return $m[3] . '/' . $m[2] . '/' . $m[1];
        }

        // Handle year-month format (Y-m) -> display as m/Y
        if (preg_match('/^(\d{4})-(\d{2})$/', $this->pajak, $m)) {
            return $m[2] . '/' . $m[1];
        }

        // Return as-is if format is unknown
        return $this->pajak;
    }

    public function getPajakIsActiveAttribute(): bool
    {
        if (!is_string($this->pajak)) {
            return false;
        }

        try {
            // Try to parse as full date first (Y-m-d)
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->pajak)) {
                $expiry = Carbon::createFromFormat('Y-m-d', $this->pajak);
            } 
            // Fall back to year-month format (Y-m)
            elseif (preg_match('/^\d{4}-\d{2}$/', $this->pajak)) {
                $expiry = Carbon::createFromFormat('Y-m', $this->pajak)->endOfMonth();
            } 
            else {
                return false;
            }
        } catch (\Throwable $e) {
            return false;
        }

        // Tax is active if the expiry date is today or in the future
        return now()->lessThanOrEqualTo($expiry);
    }

    public function getPajakIsExpiringSoonAttribute(): bool
    {
        if (!is_string($this->pajak)) {
            return false;
        }
        
        try {
            // Parse the date
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->pajak)) {
                $expiryDate = Carbon::createFromFormat('Y-m-d', $this->pajak);
            } elseif (preg_match('/^\d{4}-\d{2}$/', $this->pajak)) {
                $expiryDate = Carbon::createFromFormat('Y-m', $this->pajak)->endOfMonth();
            } else {
                return false;
            }
            
            // Check if expiry is within the next 60 days
            $now = now();
            $twoMonthsLater = now()->addDays(60);
            
            return $expiryDate->between($now, $twoMonthsLater);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
