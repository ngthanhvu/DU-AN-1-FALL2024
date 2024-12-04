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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // Loại hành động: create, update, delete
            $table->string('model'); // Tên model hoặc bảng bị ảnh hưởng
            $table->unsignedBigInteger('user_id')->nullable(); // ID của người thực hiện (nếu có)
            $table->json('changes')->nullable(); // Thông tin thay đổi (trước và sau)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
