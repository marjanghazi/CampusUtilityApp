<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default departments
        DB::table('departments')->insert([
            ['name' => 'Computer Science', 'code' => 'CS', 'description' => 'Computer Science Department'],
            ['name' => 'Information Technology', 'code' => 'IT', 'description' => 'Information Technology Department'],
            ['name' => 'Software Engineering', 'code' => 'SE', 'description' => 'Software Engineering Department'],
            ['name' => 'English', 'code' => 'ENG', 'description' => 'English Department'],
            ['name' => 'Business Administration', 'code' => 'BBA', 'description' => 'Business Administration Department'],
            ['name' => 'Mathematics', 'code' => 'MATH', 'description' => 'Mathematics Department'],
            ['name' => 'Physics', 'code' => 'PHY', 'description' => 'Physics Department'],
            ['name' => 'Chemistry', 'code' => 'CHEM', 'description' => 'Chemistry Department'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};