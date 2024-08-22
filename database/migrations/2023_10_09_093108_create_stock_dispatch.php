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
        Schema::create('stock_dispatch', function (Blueprint $table) {
            $table->id();
            $table->date('stock_date');
            $table->unsignedBigInteger('vendor_branch_id');
            $table->enum('status', ['0', '1'])->default(0)->comment('1 => Active', '0=>InActive');
            $table->string('total_amount', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_dispatch');
    }
};
