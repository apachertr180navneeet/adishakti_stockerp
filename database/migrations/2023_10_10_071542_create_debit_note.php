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
        Schema::create('debit_note', function (Blueprint $table) {
            $table->id();
            $table->string('debit_note', 255);
            $table->date('debit_date');
            $table->enum('type', ['0', '1'])->default(0)->comment('1 => Branch', '0=>Customer');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('grand_total', 255);
            $table->string('add_amount', 255);
            $table->string('final_amunt', 255);
            $table->enum('status', ['0', '1'])->default(0)->comment('1 => Active', '0=>InActive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debit_note');
    }
};
