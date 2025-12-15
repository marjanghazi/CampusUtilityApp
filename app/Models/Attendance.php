<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_id',
        'department_id',
        'total_classes',
        'attended',
        'date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Get percentage
    public function getPercentageAttribute()
    {
        if ($this->total_classes > 0) {
            return ($this->attended / $this->total_classes) * 100;
        }
        return 0;
    }

    // Get status color
    public function getStatusColorAttribute()
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 75) return 'bg-green-100 text-green-800';
        if ($percentage >= 50) return 'bg-yellow-100 text-yellow-800';
        return 'bg-red-100 text-red-800';
    }

    // Get status text
    public function getStatusTextAttribute()
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 75) return 'Good';
        if ($percentage >= 50) return 'Average';
        return 'Low';
    }
}