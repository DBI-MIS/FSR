<?php

use App\Models\Contact;
use App\Models\DbeDirectory;
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
        Schema::create('contacts_directory', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contact::class)->nullable();
            $table->foreignIdFor(DbeDirectory::class)->nullable();
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts_directory');
    }
};
