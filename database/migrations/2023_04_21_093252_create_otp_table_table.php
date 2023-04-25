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
        Schema::create('otp_table', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('otp');
            $table->string('status');
            $table->string('expire_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_table');
    }
};

// php artisan migrate --path=/database/migrations/2023_04_21_093252_create_otp_table_table.php