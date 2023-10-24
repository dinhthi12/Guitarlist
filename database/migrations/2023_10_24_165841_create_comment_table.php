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
        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pro_id');
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->integer('rate');
            $table->timestamp('time');
            $table->integer('status')->default(0);
            $table->timestamps();
            // Tạo cột khóa ngoại kết nối với bảng 'user'
            $table->foreign('user_id')->references('id')->on('user');
            // Tạo cột khóa ngoại kết nối với bảng 'product'
            $table->foreign('pro_id')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment');
    }
};
