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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('pro_id');
            $table->string('name');
            $table->integer('number');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            // Tạo cột khóa ngoại kết nối với bảng 'product'
            $table->foreign('pro_id')->references('id')->on('product');
            // Tạo cột khóa ngoại kết nối với bảng 'order'
            $table->foreign('order_id')->references('id')->on('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
