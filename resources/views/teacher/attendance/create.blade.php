@extends('layouts.app')

@section('title', 'Mark Attendance')

@php
    $pageTitle = 'Mark Attendance';
    $pageSubtitle = 'Add new attendance record';
@endphp

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Mark Attendance</h2>
        
<form action="{{ route('teacher.attendance.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <!-- Student Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Student
                    </label>
                    <select name="user_id" required
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Subject Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Subject
                    </label>
                    <select name="subject" required
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}">{{ $subject }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Classes Attended -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Classes Attended
                    </label>
                    <input type="number" name="attended" min="0" required
                           class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter number of classes attended">
                </div>

                <!-- Total Classes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Total Classes
                    </label>
                    <input type="number" name="total_classes" min="0" required
                           class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter total number of classes">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t">
<a href="{{ route('teacher.attendance.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save Attendance
                </button>
            </div>
        </form>
    </div>
</div>
@endsection