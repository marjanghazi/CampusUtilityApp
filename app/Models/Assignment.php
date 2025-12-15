<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'subject',
        'teacher_id',
        'due_date',
        'total_marks',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function getStatusAttribute()
    {
        return now()->gt($this->due_date) ? 'Overdue' : 'Active';
    }

    public function getIsOverdueAttribute()
    {
        return now()->gt($this->due_date);
    }
}