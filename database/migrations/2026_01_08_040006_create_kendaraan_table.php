<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_qr');
            $table->string('pemegang');
            $table->string('nip');
            $table->string('jabatan');
            $table->string('unit_kerja');
            $table->string('nama_kendaraan');
            $table->string('no_polisi');
            $table->integer('thn_kendaraan');
            $table->string('no_rangka');
            $table->string('no_mesin');
            $table->string('pajak');
            $table->string('jenis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
