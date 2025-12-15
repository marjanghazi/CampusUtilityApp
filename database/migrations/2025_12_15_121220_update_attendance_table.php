<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Remove old subject column
            $table->dropColumn('subject');
            
            // Add new foreign keys
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('status')->default('present'); // present, absent, late
            $table->text('remarks')->nullable();
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['department_id']);
            $table->dropColumn(['subject_id', 'department_id', 'date', 'status', 'remarks']);
            
            // Re-add old column
            $table->string('subject')->nullable();
        });
    }
};