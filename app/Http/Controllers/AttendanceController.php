<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // This is for TEACHER to view all attendance records
        $attendances = Attendance::with('user')->get();
        $students = User::where('role', 'student')->get();
        $subjects = Attendance::distinct()->pluck('subject');
        
        return view('teacher.attendance.index', compact('attendances', 'students', 'subjects'));
    }

    /**
     * Student: View their own attendance
     */
    public function studentIndex()
    {
        $attendances = Attendance::where('id', auth()->id())->get();
        
        // Calculate overall statistics
        $totalClasses = $attendances->sum('total_classes');
        $totalAttended = $attendances->sum('attended');
        $totalMissed = $totalClasses - $totalAttended;
        $overallPercentage = $totalClasses > 0 ? ($totalAttended / $totalClasses) * 100 : 0;
        
        return view('student.attendance', compact(
            'attendances',
            'totalClasses',
            'totalAttended',
            'totalMissed',
            'overallPercentage'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // TEACHER: Form to mark attendance for a student
        $students = User::where('role', 'student')->get();
        $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Computer Science'];
        
        return view('teacher.attendance.create', compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'attended' => 'required|integer|min:0',
            'total_classes' => 'required|integer|min:0|gte:attended',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'id' => $request->id,
                'subject' => $request->subject,
            ],
            [
                'attended' => $request->attended,
                'total_classes' => $request->total_classes,
            ]
        );

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance marked successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        // TEACHER: View individual attendance record
        return view('teacher.attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        // TEACHER: Edit attendance record
        $students = User::where('role', 'student')->get();
        $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Computer Science'];
        
        return view('teacher.attendance.edit', compact('attendance', 'students', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'attended' => 'required|integer|min:0',
            'total_classes' => 'required|integer|min:0|gte:attended',
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record deleted successfully!');
    }

    /**
     * Bulk attendance marking
     */
    public function bulkMark(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'date' => 'required|date',
            'attendance_data' => 'required|array',
            'attendance_data.*.student_id' => 'required|exists:users,id',
            'attendance_data.*.status' => 'required|in:present,absent',
        ]);

        foreach ($request->attendance_data as $data) {
            $attendance = Attendance::firstOrNew([
                'id' => $data['student_id'],
                'subject' => $request->subject,
            ]);

            // Increment total classes and attended based on status
            $attendance->total_classes += 1;
            if ($data['status'] === 'present') {
                $attendance->attended += 1;
            }

            $attendance->save();
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Bulk attendance marked successfully!');
    }
}