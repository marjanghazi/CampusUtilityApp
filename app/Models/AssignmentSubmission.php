<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'file_name',
        'marks',
        'feedback',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getIsSubmittedAttribute()
    {
        return !is_null($this->submitted_at);
    }

    public function getIsGradedAttribute()
    {
        return !is_null($this->marks);
    }

    public function getGradeStatusAttribute()
    {
        if (!$this->is_submitted) return 'Not Submitted';
        if (!$this->is_graded) return 'Submitted (Not Graded)';
        return 'Graded';
    }

    public function getGradeColorAttribute()
    {
        if (!$this->is_submitted) return 'bg-gray-100 text-gray-800';
        if (!$this->is_graded) return 'bg-blue-100 text-blue-800';
        
        $percentage = ($this->marks / $this->assignment->total_marks) * 100;
        
        if ($percentage >= 80) return 'bg-green-100 text-green-800';
        if ($percentage >= 60) return 'bg-yellow-100 text-yellow-800';
        return 'bg-red-100 text-red-800';
    }
}