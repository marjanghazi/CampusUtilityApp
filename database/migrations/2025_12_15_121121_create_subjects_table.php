<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->integer('credit_hours')->default(3);
            $table->timestamps();
        });

        // Insert default subjects
        $departments = DB::table('departments')->get();
        $subjectsData = [];
        
        foreach ($departments as $dept) {
            switch ($dept->code) {
                case 'CS':
                    $subjectsData[] = ['code' => 'CS101', 'name' => 'Programming Fundamentals', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'CS201', 'name' => 'Data Structures', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'CS301', 'name' => 'Algorithms', 'department_id' => $dept->id, 'credit_hours' => 3];
                    break;
                case 'IT':
                    $subjectsData[] = ['code' => 'IT101', 'name' => 'Networking Basics', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'IT201', 'name' => 'Database Systems', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'IT301', 'name' => 'Web Technologies', 'department_id' => $dept->id, 'credit_hours' => 3];
                    break;
                case 'SE':
                    $subjectsData[] = ['code' => 'SE101', 'name' => 'Software Engineering', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'SE201', 'name' => 'Software Design', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'SE301', 'name' => 'Software Testing', 'department_id' => $dept->id, 'credit_hours' => 3];
                    break;
                case 'ENG':
                    $subjectsData[] = ['code' => 'ENG101', 'name' => 'English Composition', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'ENG201', 'name' => 'British Literature', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'ENG301', 'name' => 'American Literature', 'department_id' => $dept->id, 'credit_hours' => 3];
                    break;
                case 'BBA':
                    $subjectsData[] = ['code' => 'BBA101', 'name' => 'Principles of Management', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'BBA201', 'name' => 'Marketing Management', 'department_id' => $dept->id, 'credit_hours' => 3];
                    $subjectsData[] = ['code' => 'BBA301', 'name' => 'Financial Accounting', 'department_id' => $dept->id, 'credit_hours' => 3];
                    break;
            }
        }
        
        DB::table('subjects')->insert($subjectsData);
    }

    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};