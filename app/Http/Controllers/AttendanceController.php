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
        $teacherId = auth()->id();

        // Get all subjects for dropdown
        $subjects = Subject::all();

        // Get all attendance records for this teacher with related user & subject
        $attendances = Attendance::with(['user', 'subject'])
            ->where('teacher_id', $teacherId)
            ->get();

        return view('teacher.attendance.index', compact('attendances', 'subjects'));
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create()
    {
        $teacher = auth()->user();
        $departments = Department::all();
        $students = User::where('role', 'student')->with('departmentRelation')->get();

        // Only subjects assigned to this teacher
        $teacherSubjects = Subject::where('teacher_id', $teacher->id)->get();

        // Pass $subjects so Blade doesn’t break
        $subjects = $teacherSubjects;

        return view('teacher.attendance.create', compact('departments', 'students', 'teacherSubjects', 'subjects'));
    }

    /**
     * Store a newly created attendance record.
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

        Attendance::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'subject_id' => $request->subject_id,
                'date' => $request->date,
            ],
            [
                'teacher_id' => auth()->id(),
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
     * Show the form for editing a record.
     */
    public function edit(Attendance $attendance)
    {
        $departments = Department::all();
        $students = User::where('role', 'student')->with('departmentRelation')->get();
        $teacherSubjects = Subject::where('teacher_id', auth()->id())->get();

        return view('teacher.attendance.edit', compact('attendance', 'departments', 'students', 'teacherSubjects'));
    }

    /**
     * Update a specific attendance record.
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
     * Delete a record.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Attendance record deleted successfully!');
    }

    /**
     * Bulk attendance form.
     */
    public function bulkCreate()
    {
        $teacher = auth()->user();
        $departments = Department::all();
        $teacherSubjects = Subject::where('teacher_id', $teacher->id)->get();

        $studentsByDepartment = User::where('role', 'student')
            ->with('departmentRelation')
            ->get()
            ->groupBy('department');

        return view('teacher.attendance.bulk', compact('departments', 'teacherSubjects', 'studentsByDepartment'));
    }

    /**
     * Store bulk attendance.
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
            $attendance = Attendance::firstOrNew([
                'user_id' => $record['student_id'],
                'subject_id' => $request->subject_id,
                'date' => $request->date,
            ]);

            $attendance->teacher_id = auth()->id();
            $attendance->department_id = $request->department_id;
            $attendance->total_classes = ($attendance->total_classes ?? 0) + 1;
            $attendance->attended = ($attendance->attended ?? 0) + ($record['status'] === 'present' || $record['status'] === 'late' ? 1 : 0);
            $attendance->status = $record['status'];
            $attendance->remarks = $record['remarks'] ?? null;

            $attendance->save();
        }

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Bulk attendance marked successfully!');
    }

    /**
     * Student: view own attendance.
     */
    public function studentIndex()
    {
        $studentId = auth()->id();
        $attendances = Attendance::where('user_id', $studentId)
            ->with(['subject', 'department'])
            ->get();

        $totalClasses = $attendances->sum('total_classes');
        $totalAttended = $attendances->sum('attended');
        $totalMissed = $totalClasses - $totalAttended;
        $overallPercentage = $totalClasses > 0 ? ($totalAttended / $totalClasses) * 100 : 0;

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
