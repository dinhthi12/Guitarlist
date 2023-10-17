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
        Schema::create('detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pro_id');
            $table->string('mechanicalSet')->default('N/A');
            $table->string('soundboard')->default('N/A');
            $table->integer('keyboard')->default('N/A');
            $table->string('size')->default('N/A');
            $table->integer('weight')->default('N/A');
            $table->integer('manufacture')->default('N/A');
            $table->timestamps();
            // Tạo cột khóa ngoại kết nối với bảng 'product'
            $table->foreign('pro_id')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail');
    }
};
