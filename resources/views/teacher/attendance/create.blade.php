@extends('layouts.app')

@section('title', 'Mark Attendance')

@php
$pageTitle = 'Mark Attendance';
$pageSubtitle = 'Add attendance record';
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Mark Attendance</h2>
                <p class="text-gray-600">Mark attendance for a single student</p>
            </div>
            <a href="{{ route('teacher.attendance.bulk.create') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Bulk Marking
            </a>
        </div>

        {{-- Errors --}}
        @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('teacher.attendance.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Department (Optional) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Department
                    </label>
                    <select name="department_id"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500">
                        <option value="">Select Department (Optional)</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">
                            {{ $department->name }} ({{ $department->code }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Subject --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Subject <span class="text-red-500">*</span>
                    </label>
                    <select name="subject_id" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">
                            {{ $subject->name }} ({{ $subject->code }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Student --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Student <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500">
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}">
                            {{ $student->name }} ({{ $student->roll_number ?? 'N/A' }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date" required
                        value="{{ now()->format('Y-m-d') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500">
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500">
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                    </select>
                </div>

                {{-- Classes Attended --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Classes Attended <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="attended" min="0" value="1" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500"
                        placeholder="Enter number of classes attended">
                </div>

                {{-- Total Classes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Total Classes <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="total_classes" min="1" value="1" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500"
                        placeholder="Enter total number of classes">
                </div>

                {{-- Remarks --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Remarks
                    </label>
                    <textarea name="remarks" rows="3"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500"
                        placeholder="Optional remarks"></textarea>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t">
                <a href="{{ route('teacher.attendance.index') }}"
                    class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
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
