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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('cateitem_id');
            $table->decimal('price', 10, 2);
            $table->string('image')->default('');
            $table->integer('view')->default(0);
            $table->integer('quantity');
            $table->text('detail');
            $table->tinyInteger('discount')->default(0);
            $table->tinyInteger('hot')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
             // Tạo cột khóa ngoại kết nối với bảng 'category item'
             $table->foreign('cateitem_id')->references('id')->on('category_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
