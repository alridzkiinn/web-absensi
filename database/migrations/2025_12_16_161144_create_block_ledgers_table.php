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
        Schema::create('block_ledgers', function (Blueprint $table) {
            $table->id();
            $table->text('data');
            $table->timestamp('timestamp');
            $table->string('previous_hash')->nullable();
            $table->string('current_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_ledgers');
    }
};
