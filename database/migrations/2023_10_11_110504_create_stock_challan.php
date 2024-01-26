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
        Schema::create('stock_challan', function (Blueprint $table) {
            $table->id();
            $table->string('challan_number', 255);
            $table->date('stock_dispatch_date');
            $table->unsignedBigInteger('customer_id');
            $table->string('address', 255);
            $table->unsignedBigInteger('item_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_challan');
    }
};
