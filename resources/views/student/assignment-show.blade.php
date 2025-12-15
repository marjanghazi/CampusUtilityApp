@extends('layouts.app')

@section('title', $assignment->title)

@php
    $pageTitle = $assignment->title;
    $pageSubtitle = 'Assignment Details';
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Assignment Header -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $assignment->title }}</h1>
                    <div class="flex items-center mt-2 space-x-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                            {{ $assignment->subject }}
                        </span>
                        <span class="text-gray-600">
                            Assigned by: {{ $assignment->teacher->name }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-lg font-semibold {{ $assignment->is_overdue ? 'text-red-600' : 'text-gray-800' }}">
                        Due: {{ $assignment->due_date->format('M d, Y \\a\\t h:i A') }}
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        Total Marks: {{ $assignment->total_marks }}
                    </div>
                </div>
            </div>
            
            @if($assignment->description)
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-medium text-gray-700 mb-2">Description</h3>
                <p class="text-gray-600 whitespace-pre-line">{{ $assignment->description }}</p>
            </div>
            @endif
        </div>

        <!-- Submission Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Submission Status</h3>
            
            @if($submission)
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-medium text-gray-700">Submitted File</h4>
                        <div class="flex items-center mt-2">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-gray-600">{{ $submission->file_name }}</span>
                        </div>
                        <div class="text-sm text-gray-500 mt-1">
                            Submitted: {{ $submission->submitted_at->format('M d, Y \\a\\t h:i A') }}
                        </div>
                    </div>
                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        View File
                    </a>
                </div>
                
                @if($submission->marks !== null)
                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-medium text-gray-700 mb-2">Grading</h4>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold text-gray-800">
                                {{ $submission->marks }}/{{ $assignment->total_marks }}
                            </div>
                            <div class="text-lg font-medium {{ $submission->grade_color }}">
                                {{ number_format(($submission->marks / $assignment->total_marks) * 100, 1) }}%
                            </div>
                        </div>
                        @if($submission->feedback)
                        <div class="text-right">
                            <div class="text-sm text-gray-600">Feedback:</div>
                            <div class="text-gray-700">{{ $submission->feedback }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="mt-4 text-center text-gray-500">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Awaiting teacher's evaluation
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 mb-4">You haven't submitted this assignment yet</p>
                @if($assignment->is_overdue)
                <p class="text-red-500 text-sm mb-4">This assignment is overdue</p>
                @endif
            </div>
            @endif
        </div>

        <!-- Upload Form -->
        @if(!$submission || $assignment->is_overdue)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                {{ $submission ? 'Resubmit Assignment' : 'Submit Assignment' }}
            </h3>
            
            <form action="{{ route('student.assignments.upload', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload File (PDF, Word, or ZIP)
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="assignment_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="assignment_file" name="assignment_file" type="file" class="sr-only" accept=".pdf,.doc,.docx,.zip">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PDF, DOC, DOCX, ZIP up to 10MB
                                </p>
                            </div>
                        </div>
                        @error('assignment_file')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                    <a href="{{ route('student.assignments') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        {{ $submission ? 'Resubmit' : 'Submit Assignment' }}
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Deadline Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="font-medium text-blue-800">Important Information</h4>
                    <ul class="mt-2 text-sm text-blue-700 space-y-1">
                        <li>• Files must be in PDF, Word, or ZIP format</li>
                        <li>• Maximum file size is 10MB</li>
                        <li>• You can resubmit before the deadline</li>
                        <li>• Late submissions may be penalized</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection