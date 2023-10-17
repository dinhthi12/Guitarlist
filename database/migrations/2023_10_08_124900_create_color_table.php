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
        Schema::create('color', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pro_id');
            $table->string('color');
            $table->decimal('price', 10, 2);
            $table->string('image')->default('');
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
        Schema::dropIfExists('color');
    }
};
