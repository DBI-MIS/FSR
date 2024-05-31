<?php

use App\Models\Equipment;
use App\Models\Fsr;
use App\Models\Project;
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
        Schema::create('fsr_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fsr::class)->nullable();
            $table->foreignIdFor(Equipment::class)->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fsr_equipments');
    }
};
