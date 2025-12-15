<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Department;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get teacher's assigned subjects and departments
        $teacherId = auth()->id();
        
        // For now, show all departments and subjects
        $departments = Department::all();
        $subjects = Subject::all();
        $students = User::where('role', 'student')->with('departmentRelation')->get();
        
        // Group students by department
        $studentsByDepartment = $students->groupBy('department');
        
        return view('teacher.attendance.index', compact('departments', 'subjects', 'students', 'studentsByDepartment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $subjects = Subject::all();
        $students = User::where('role', 'student')->with('departmentRelation')->get();
        
        return view('teacher.attendance.create', compact('departments', 'subjects', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'department_id' => 'required|exists:departments,id',
            'attended' => 'required|integer|min:0',
            'total_classes' => 'required|integer|min:0|gte:attended',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
            'remarks' => 'nullable|string|max:500',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'subject_id' => $request->subject_id,
                'date' => $request->date,
            ],
            [
                'department_id' => $request->department_id,
                'attended' => $request->attended,
                'total_classes' => $request->total_classes,
                'status' => $request->status,
                'remarks' => $request->remarks,
            ]
        );

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Attendance marked successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        return view('teacher.attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $departments = Department::all();
        $subjects = Subject::all();
        $students = User::where('role', 'student')->get();
        
        return view('teacher.attendance.edit', compact('attendance', 'departments', 'subjects', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'department_id' => 'required|exists:departments,id',
            'attended' => 'required|integer|min:0',
            'total_classes' => 'required|integer|min:0|gte:attended',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late',
            'remarks' => 'nullable|string|max:500',
        ]);

        $attendance->update($request->all());

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Attendance updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Attendance record deleted successfully!');
    }

    /**
     * Bulk attendance marking
     */
    public function bulkCreate()
    {
        $departments = Department::all();
        $subjects = Subject::all();
        
        // Get students grouped by department
        $students = User::where('role', 'student')
            ->with('departmentRelation')
            ->get()
            ->groupBy('department');
        
        return view('teacher.attendance.bulk', compact('departments', 'subjects', 'students'));
    }

    /**
     * Store bulk attendance
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'department_id' => 'required|exists:departments,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:users,id',
            'attendance.*.status' => 'required|in:present,absent,late',
            'attendance.*.remarks' => 'nullable|string|max:255',
        ]);

        foreach ($request->attendance as $record) {
            // Find existing attendance record for this student on this date and subject
            $attendance = Attendance::firstOrNew([
                'user_id' => $record['student_id'],
                'subject_id' => $request->subject_id,
                'date' => $request->date,
            ]);

            // Update attendance counts
            $attendance->department_id = $request->department_id;
            $attendance->total_classes = ($attendance->total_classes ?? 0) + 1;
            
            if ($record['status'] === 'present' || $record['status'] === 'late') {
                $attendance->attended = ($attendance->attended ?? 0) + 1;
            }
            
            $attendance->status = $record['status'];
            $attendance->remarks = $record['remarks'] ?? null;
            
            $attendance->save();
        }

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Bulk attendance marked successfully!');
    }

    /**
     * Student: View their own attendance
     */
    public function studentIndex()
    {
        $studentId = auth()->id();
        $attendances = Attendance::where('user_id', $studentId)
            ->with(['subject', 'department'])
            ->get();
        
        // Calculate overall statistics
        $totalClasses = $attendances->sum('total_classes');
        $totalAttended = $attendances->sum('attended');
        $totalMissed = $totalClasses - $totalAttended;
        $overallPercentage = $totalClasses > 0 ? ($totalAttended / $totalClasses) * 100 : 0;
        
        // Group by subject
        $attendancesBySubject = $attendances->groupBy('subject.name');
        
        return view('student.attendance', compact(
            'attendances',
            'attendancesBySubject',
            'totalClasses',
            'totalAttended',
            'totalMissed',
            'overallPercentage'
        ));
    }
}