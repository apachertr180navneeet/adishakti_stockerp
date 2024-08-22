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
        Schema::create('user_detail', function (Blueprint $table) {
            $table->id('user_detail_id');
            $table->unsignedBigInteger('user_id');
            $table->string('address', 255);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('pincode', 255);
            $table->enum('gender', ['0','1','2'])->default(0)->comment('1 => male', '0=>female', '2=>trangender');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_detail');
    }
};
