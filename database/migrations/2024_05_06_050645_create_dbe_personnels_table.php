<?php

use App\Models\DbePersonnel;
use App\Models\Fsr;
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
        
        Schema::create('dbe_personnels', function (Blueprint $table) {
            $table->id();
            $table->string('profile_photo_path')->nullable();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('employee_status')->default('Active')->nullable();
            $table->string('status')->default('on_site')->nullable();
            $table->integer('order_column')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbe_personnels');
    }
};
