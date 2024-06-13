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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->string('nm_pengeluaran');
            $table->string('catatan');
            $table->bigInteger('kd_kategori_pengeluaran');
            $table->string('tgl_pengeluaran');
            $table->bigInteger('jml_pengeluaran');
            $table->bigInteger('kd_user'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
