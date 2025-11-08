<?php

use App\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();   
            $table->foreignId('course_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();                              
            $table->string('code', 20)->unique();        
            $table->string('name', 100);                
            $table->text('description')->nullable();     
            $table->unsignedTinyInteger('credits')->default(0);
            $table->unsignedSmallInteger('hours')->default(0);   
            $table->decimal('price', 8, 2)->default(0);  
            $table->date('start_date')->nullable();      
            $table->date('end_date')->nullable();        
            $table->boolean('published')->default(false);

            // Relación con users (opcional: dueño/profesor)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // JSON (opciones extra)
            $table->json('options')->nullable();

            // Soft deletes + timestamps
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['course_id','user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses_user');
    }
};
