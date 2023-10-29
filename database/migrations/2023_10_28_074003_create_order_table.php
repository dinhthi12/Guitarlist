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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('delivery_id');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->boolean('status')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
            // Tạo cột khóa ngoại kết nối với bảng 'user'
            $table->foreign('user_id')->references('id')->on('user');
            // Tạo cột khóa ngoại kết nối với bảng 'address'
            $table->foreign('address_id')->references('id')->on('address');
            // Tạo cột khóa ngoại kết nối với bảng 'delivery'
            $table->foreign('delivery_id')->references('id')->on('delivery');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
