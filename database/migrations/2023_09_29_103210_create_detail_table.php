<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pro_id');
            $table->string('type');
            $table->string('ingredient');
            $table->integer('Keyboard');
            $table->integer('reliability');
            $table->string('tone');
            $table->integer('hight');
            $table->integer('width');
            $table->integer('depth');
            $table->integer('weight');
            // Tạo cột khóa ngoại kết nối với bảng 'product'
            $table->foreign('pro_id')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail');
    }
};
