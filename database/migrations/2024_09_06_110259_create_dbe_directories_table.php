<?php

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
        Schema::create('dbe_directories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class)->nullable();
            $table->json('contact_no')->nullable();
            // $table->string('contact_no')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('designation')->nullable();
            $table->string('email_address')->nullable();
            $table->foreignIdFor(Fsr::class)->nullable();
            $table->string('status')->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dbe_directories');
    }
};
