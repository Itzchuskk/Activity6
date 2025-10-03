<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();                                // id big int unsigned
            $table->string('code', 20)->unique();        // VARCHAR(20)
            $table->string('name', 100);                 // VARCHAR(100)
            $table->text('description')->nullable();     // TEXT
            $table->unsignedTinyInteger('credits')->default(0);  // UNSIGNED TINYINT
            $table->unsignedSmallInteger('hours')->default(0);   // UNSIGNED SMALLINT
            $table->decimal('price', 8, 2)->default(0);  // DECIMAL(8,2)
            $table->date('start_date')->nullable();      // DATE
            $table->date('end_date')->nullable();        // DATE
            $table->boolean('published')->default(false);// BOOLEAN

            // Relación con users (opcional: dueño/profesor)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // JSON (opciones extra)
            $table->json('options')->nullable();

            // Soft deletes + timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
