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
        Schema::table('stock_dispatch', function (Blueprint $table) {
            $table->enum('type', ['0', '1'])->default(0)->comment('1 => Branch', '0=>Customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_dispatch_name', function (Blueprint $table) {
            //
        });
    }
};
