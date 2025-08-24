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
         
        // First drop the foreign key from appointments
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['patient_id']); // remove FK constraint
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::dropIfExists('patient');
             
    }

    /**x
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
