<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // For Teachers: Show all assignments they created
        if (auth()->user()->role === 'teacher') {
            $assignments = Assignment::where('teacher_id', auth()->id())
                ->withCount('submissions')
                ->latest()
                ->get();
            
            return view('teacher.assignments.index', compact('assignments'));
        }
        
        // For Students: Show all assignments
        $assignments = Assignment::with(['submissions' => function($query) {
            $query->where('student_id', auth()->id());
        }])->latest()->get();
        
        return view('student.assignments', compact('assignments'));
    }

    /**
     * Student: View assignment details and upload
     */
    public function showAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);
        $submission = AssignmentSubmission::where('assignment_id', $id)
            ->where('student_id', auth()->id())
            ->first();
        
        return view('student.assignment-show', compact('assignment', 'submission'));
    }

    /**
     * Student: Upload assignment
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'assignment_file' => 'required|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);
        
        $assignment = Assignment::findOrFail($id);
        
        // Check if already submitted
        $existingSubmission = AssignmentSubmission::where('assignment_id', $id)
            ->where('student_id', auth()->id())
            ->first();
        
        if ($existingSubmission) {
            // Delete old file
            Storage::delete($existingSubmission->file_path);
            
            // Update existing submission
            $file = $request->file('assignment_file');
            $path = $file->store('assignments/submissions');
            
            $existingSubmission->update([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'submitted_at' => now(),
            ]);
            
            return back()->with('success', 'Assignment resubmitted successfully!');
        }
        
        // Create new submission
        $file = $request->file('assignment_file');
        $path = $file->store('assignments/submissions');
        
        AssignmentSubmission::create([
            'assignment_id' => $id,
            'student_id' => auth()->id(),
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'submitted_at' => now(),
        ]);
        
        return back()->with('success', 'Assignment submitted successfully!');
    }

    /**
     * Teacher: View assignment submissions
     */
    public function showSubmissions($id)
    {
        $assignment = Assignment::with(['submissions.student'])->findOrFail($id);
        return view('teacher.assignments.submissions', compact('assignment'));
    }

    /**
     * Teacher: Grade submission
     */
    public function gradeSubmission(Request $request, $submissionId)
    {
        $request->validate([
            'marks' => 'required|integer|min:0',
            'feedback' => 'nullable|string|max:1000',
        ]);
        
        $submission = AssignmentSubmission::findOrFail($submissionId);
        
        $submission->update([
            'marks' => $request->marks,
            'feedback' => $request->feedback,
        ]);
        
        return back()->with('success', 'Submission graded successfully!');
    }

    /**
     * Teacher: Download submission
     */
    public function downloadSubmission($submissionId)
    {
        $submission = AssignmentSubmission::findOrFail($submissionId);
        
        if (!Storage::exists($submission->file_path)) {
            return back()->with('error', 'File not found.');
        }
        
        return Storage::download($submission->file_path, $submission->file_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Computer Science'];
        return view('teacher.assignments.create', compact('subjects'));
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'due_date' => 'required|date|after:now',
            'total_marks' => 'required|integer|min:1|max:1000',
        ]);
        
        Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $request->subject,
            'teacher_id' => auth()->id(),
            'due_date' => $request->due_date,
            'total_marks' => $request->total_marks,
        ]);
        
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignment::with(['submissions.student'])->findOrFail($id);
        return view('teacher.assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);
        $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'Computer Science'];
        
        return view('teacher.assignments.edit', compact('assignment', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'due_date' => 'required|date',
            'total_marks' => 'required|integer|min:1|max:1000',
        ]);
        
        $assignment->update($request->all());
        
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        
        // Delete all submissions and files
        foreach ($assignment->submissions as $submission) {
            Storage::delete($submission->file_path);
            $submission->delete();
        }
        
        $assignment->delete();
        
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully!');
    }
}