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

        Schema::create('kamars', function (Blueprint $table) {
            $table->increments('id_room');
            $table->string('gambar')->nullable();
            $table->string('nama_kamar');
            $table->string('status')->default('kosong');
            $table->timestamps();

        });
        Schema::create('divisis', function (Blueprint $table) {
            $table->increments('id_divisi');
            $table->string('gambar')->nullable();
            $table->string('nama_divisi');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
        Schema::dropIfExists('divisis');
    }
};
