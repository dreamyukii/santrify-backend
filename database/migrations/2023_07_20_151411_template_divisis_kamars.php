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
        DB::table('kamars')->insert([
            array(
                'nama_kamar' => "Schale",
                'id' => 1,
                'status' => "kosong",
            )
            
        ]);

        DB::table('divisis')->insert([
            array(
                'nama_divisi' => "Kelas 1A",
                'id' => 1
            )
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
