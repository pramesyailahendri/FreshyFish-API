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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_ikan');
            $table->decimal('harga_ikan', 10, 2);
            $table->float('jumlah_ikan', 8 , 2);
            $table->string('foto_ikan')->nullable();
            $table->text('deskripsi_ikan')->nullable();
            $table->string('habitat_ikan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
