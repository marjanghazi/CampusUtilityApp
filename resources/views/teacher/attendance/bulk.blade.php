@extends('layouts.app')

@section('title', 'Bulk Attendance Marking')

@php
    $pageTitle = 'Bulk Attendance Marking';
    $pageSubtitle = 'Mark attendance for multiple students at once';
@endphp

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Bulk Attendance Marking</h2>
                <p class="text-gray-600">Mark attendance for all students in a department</p>
            </div>
            <a href="{{ route('teacher.attendance.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Single Marking
            </a>
        </div>
        
        <form action="{{ route('teacher.attendance.bulk.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Department Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Department <span class="text-red-500">*</span>
                    </label>
                    <select name="department_id" required
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            id="bulk-department-select">
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
                            id="bulk-subject-select">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" data-department="{{ $subject->department_id }}">
                                {{ $subject->name }} ({{ $subject->code }})
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
            </div>

            <!-- Students List -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Student Attendance</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Roll No.
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Department
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Remarks
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="students-container">
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    Select a department to load students
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save All Attendance
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departmentSelect = document.getElementById('bulk-department-select');
    const subjectSelect = document.getElementById('bulk-subject-select');
    const studentsContainer = document.getElementById('students-container');
    
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
        
        // Load students for this department
        loadStudents(departmentId);
    });
    
    function loadStudents(departmentId) {
        // Get students data from PHP variable passed to view
        const studentsByDepartment = @json($students->toArray());
        
        // Find department code
        let departmentCode = '';
        @foreach($departments as $dept)
            if ({{ $dept->id }} == departmentId) {
                departmentCode = '{{ $dept->code }}';
            }
        @endforeach
        
        // Clear container
        studentsContainer.innerHTML = '';
        
        if (departmentCode && studentsByDepartment[departmentCode]) {
            const students = studentsByDepartment[departmentCode];
            
            students.forEach((student, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">