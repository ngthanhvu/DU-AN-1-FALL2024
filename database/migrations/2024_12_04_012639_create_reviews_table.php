<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // người dùng đánh giá
            $table->unsignedBigInteger('product_id'); // sản phẩm hoặc mục đánh giá
            $table->text('review'); // nội dung đánh giá
            $table->unsignedTinyInteger('rating')->default(0); // Thêm cột rating, mặc định là 0
            $table->string('image_path')->nullable(); // đường dẫn ảnh đánh giá
            $table->integer('likes')->default(0); // số lượt thích
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
