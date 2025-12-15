@extends('layouts.app')

@section('title', 'Mark Attendance')

@php
$pageTitle = 'Mark Attendance';
$pageSubtitle = 'Add new attendance record';
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Mark Attendance</h2>
                <p class="text-gray-600">Add attendance record for a student</p>
            </div>
            {{-- <a href="{{ route('teacher.attendance.bulk') }} --}}
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Bulk Marking
            </a>
        </div>

        <form action="{{ route('teacher.attendance.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Department Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Department <span class="text-red-500">*</span>
                    </label>
                    <select name="department_id" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        id="department-select">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">
                            {{ $department->name }} ({{ $department->code }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Subject Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Subject <span class="text-red-500">*</span>
                    </label>
                    <select name="subject_id" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        id="subject-select">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" data-department="{{ $subject->department_id }}">
                            {{ $subject->name }} ({{ $subject->code }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Student Selection -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Student <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        id="student-select">
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}" data-department="{{ $student->department }}">
                            {{ $student->name }} ({{ $student->roll_number }}) - {{ $student->department }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="date" required
                        value="{{ date('Y-m-d') }}"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                    </select>
                </div>

                <!-- Classes Attended -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Classes Attended <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="attended" min="0" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter number of classes attended"
                        value="1">
                </div>

                <!-- Total Classes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Total Classes <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="total_classes" min="1" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter total number of classes"
                        value="1">
                </div>

                <!-- Remarks -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Remarks
                    </label>
                    <textarea name="remarks" rows="3"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter any remarks (optional)"></textarea>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t">
                <a href="{{ route('teacher.attendance.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Attendance
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const departmentSelect = document.getElementById('department-select');
        const subjectSelect = document.getElementById('subject-select');
        const studentSelect = document.getElementById('student-select');

        // Filter subjects based on selected department
        departmentSelect.addEventListener('change', function() {
            const departmentId = this.value;

            // Enable/disable subject options
            Array.from(subjectSelect.options).forEach(option => {
                if (option.value === '') return;

                if (option.dataset.department === departmentId) {
                    option.hidden = false;
                    option.disabled = false;
                } else {
                    option.hidden = true;
                    option.disabled = true;
                }
            });

            // Reset subject selection
            subjectSelect.value = '';

            // Filter students based on department
            Array.from(studentSelect.options).forEach(option => {
                if (option.value === '') return;

                if (option.dataset.department === departmentId) {
                    option.hidden = false;
                    option.disabled = false;
                } else {
                    option.hidden = true;
                    option.disabled = true;
                }
            });

            // Reset student selection
            studentSelect.value = '';
        });

        // Auto-select department when student is selected
        studentSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value && selectedOption.dataset.department) {
                departmentSelect.value = '';

                // Find and select matching department
                Array.from(departmentSelect.options).forEach(option => {
                    if (option.text.includes(selectedOption.dataset.department)) {
                        departmentSelect.value = option.value;
                        departmentSelect.dispatchEvent(new Event('change'));
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection