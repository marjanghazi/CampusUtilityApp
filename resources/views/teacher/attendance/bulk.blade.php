@extends('layouts.app')

@section('title', 'Bulk Attendance Marking')

@php
$pageTitle = 'Bulk Attendance Marking';
$pageSubtitle = 'Mark attendance for multiple students at once';
@endphp

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Bulk Attendance Marking</h2>
                <p class="text-gray-600">Mark attendance for students</p>
            </div>
            <a href="{{ route('teacher.attendance.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Single Marking
            </a>
        </div>

        {{-- Error --}}
        @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('teacher.attendance.bulk.store') }}" method="POST">
            @csrf

            {{-- Filters --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- Department --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Department <span class="text-red-500">*</span>
                    </label>
                    <select id="departmentSelect" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->code }}">
                            {{ $department->name }} ({{ $department->code }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Subject (Teacher only) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Subject <span class="text-red-500">*</span>
                    </label>
                    <select name="subject_id" id="subjectSelect" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-blue-500">
                        <option value="">Select Subject</option>
                        @foreach($teacherSubjects as $subject)
                        <option value="{{ $subject->id }}"
                            data-department="{{ $subject->department->code }}">
                            {{ $subject->name }} ({{ $subject->code }})
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
            </div>

            {{-- Students --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Students</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Roll No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Student
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Remarks
                                </th>
                            </tr>
                        </thead>

                        <tbody id="studentsContainer" class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    Select department & subject
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end space-x-3 border-t pt-6">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const departmentSelect = document.getElementById('departmentSelect');
        const subjectSelect = document.getElementById('subjectSelect');
        const studentsContainer = document.getElementById('studentsContainer');

        // ✅ TS-safe JSON parsing
        const studentsByDepartment = JSON.parse(
            document.getElementById('students-data').textContent || '{}'
        );

        departmentSelect.addEventListener('change', () => {
            const dept = departmentSelect.value;

            // Filter subjects by department
            Array.from(subjectSelect.options).forEach(option => {
                if (!option.value) return;
                option.hidden = option.dataset.department !== dept;
            });

            subjectSelect.value = '';
            studentsContainer.innerHTML = emptyRow('Select subject');
        });

        subjectSelect.addEventListener('change', () => {
            loadStudents(departmentSelect.value);
        });

        function loadStudents(departmentCode) {
            const students = studentsByDepartment[departmentCode] || [];

            studentsContainer.innerHTML = '';

            if (students.length === 0) {
                studentsContainer.innerHTML = emptyRow('No students found');
                return;
            }

            students.forEach((student, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td class="px-6 py-4">
                    ${student.roll_number ?? 'N/A'}
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium">${student.name}</div>
                    <div class="text-xs text-gray-500">${student.email}</div>
                </td>
                <td class="px-6 py-4">
                    <select name="attendance[${index}][status]" required
                            class="border rounded px-3 py-1">
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                    </select>
                </td>
                <td class="px-6 py-4">
                    <input type="hidden"
                           name="attendance[${index}][student_id]"
                           value="${student.id}">
                    <input type="text"
                           name="attendance[${index}][remarks]"
                           class="border rounded px-3 py-1 w-full"
                           placeholder="Optional">
                </td>
            `;
                studentsContainer.appendChild(row);
            });
        }

        function emptyRow(message) {
            return `
            <tr>
                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                    ${message}
                </td>
            </tr>
        `;
        }
    });
</script>

@endpush
@endsection