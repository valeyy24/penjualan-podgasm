<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // Cabang yang minta
            $table->integer('jumlah');
            $table->enum('prioritas', ['Normal', 'Urgent'])->default('Normal');
            $table->enum('status', ['Pending', 'Dikirim', 'Selesai', 'Ditolak'])->default('Pending');
            $table->text('keterangan')->nullable();
            $table->date('tgl_estimasi')->nullable();
            $table->timestamps();
        });
    }
};
