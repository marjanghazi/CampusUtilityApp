@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@php
    $pageTitle = 'Teacher Dashboard';
    $pageSubtitle = 'Mark attendance, assignments and quizzes';
@endphp

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                <p class="opacity-90">Manage your classes, assignments, and student progress from here.</p>
            </div>
            <div class="bg-white/20 p-3 rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Today's Attendance</p>
                    <p class="text-2xl font-bold">85%</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pending Assignments</p>
                    <p class="text-2xl font-bold">12</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Active Quizzes</p>
                    <p class="text-2xl font-bold">3</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Upcoming Classes</p>
                    <p class="text-2xl font-bold">5</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ url('/teacher/attendance') }}" 
                   class="group p-6 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4 group-hover:bg-blue-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 group-hover:text-blue-600">Mark Attendance</h4>
                            <p class="text-sm text-gray-500 mt-1">Take today's attendance</p>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/teacher/assignments') }}" 
                   class="group p-6 border-2 border-gray-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition-all duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4 group-hover:bg-green-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 group-hover:text-green-600">Create Assignment</h4>
                            <p class="text-sm text-gray-500 mt-1">Post new assignments</p>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/teacher/quizzes') }}" 
                   class="group p-6 border-2 border-gray-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition-all duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4 group-hover:bg-purple-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 group-hover:text-purple-600">Create Quiz</h4>
                            <p class="text-sm text-gray-500 mt-1">Setup new quizzes</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Schedule -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Today's Schedule</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $schedule = [
                            ['time' => '09:00 AM', 'subject' => 'Mathematics', 'class' => 'Grade 10A', 'room' => 'Room 101'],
                            ['time' => '10:30 AM', 'subject' => 'Physics', 'class' => 'Grade 11B', 'room' => 'Lab 3'],
                            ['time' => '01:00 PM', 'subject' => 'Mathematics', 'class' => 'Grade 9C', 'room' => 'Room 102'],
                            ['time' => '03:00 PM', 'subject' => 'Staff Meeting', 'class' => 'All Teachers', 'room' => 'Conference Hall'],
                        ];
                    @endphp
                    @foreach($schedule as $item)
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                        <div class="text-center border-r border-gray-200 pr-4 mr-4">
                            <div class="text-lg font-bold text-gray-800">{{ $item['time'] }}</div>
                            <div class="text-sm text-gray-500">Duration: 1h</div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800">{{ $item['subject'] }}</h4>
                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                {{ $item['class'] }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm text-gray-600">{{ $item['room'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Pending Tasks</h3>
                    <span class="text-sm text-gray-500">3 to complete</span>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $tasks = [
                            ['task' => 'Grade Math assignments', 'subject' => 'Mathematics', 'due' => 'Today', 'priority' => 'high'],
                            ['task' => 'Prepare quiz for Physics', 'subject' => 'Physics', 'due' => 'Tomorrow', 'priority' => 'medium'],
                            ['task' => 'Update attendance records', 'subject' => 'All Subjects', 'due' => 'This week', 'priority' => 'low'],
                        ];
                    @endphp
                    @foreach($tasks as $task)
                    @php
                        $priorityColor = $task['priority'] === 'high' ? 'bg-red-100 text-red-800' : 
                                        ($task['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                    @endphp
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 mr-3">
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $task['task'] }}</h4>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Due: {{ $task['due'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                {{ $task['subject'] }}
                            </span>
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $priorityColor }}">
                                {{ ucfirst($task['priority']) }} Priority
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add New Task
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Summary -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Class Performance Summary</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subject & Class
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Avg. Attendance
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Avg. Marks
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pending Assignments
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $classes = [
                                ['subject' => 'Mathematics', 'class' => 'Grade 10A', 'attendance' => 92, 'marks' => 78, 'pending' => 5, 'status' => 'good'],
                                ['subject' => 'Physics', 'class' => 'Grade 11B', 'attendance' => 85, 'marks' => 82, 'pending' => 3, 'status' => 'good'],
                                ['subject' => 'Mathematics', 'class' => 'Grade 9C', 'attendance' => 76, 'marks' => 65, 'pending' => 8, 'status' => 'average'],
                                ['subject' => 'Physics', 'class' => 'Grade 10B', 'attendance' => 68, 'marks' => 58, 'pending' => 12, 'status' => 'needs_attention'],
                            ];
                        @endphp
                        @foreach($classes as $class)
                        @php
                            $statusColor = $class['status'] === 'good' ? 'bg-green-100 text-green-800' : 
                                          ($class['status'] === 'average' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                            $statusText = $class['status'] === 'good' ? 'Good' : 
                                         ($class['status'] === 'average' ? 'Average' : 'Needs Attention');
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $class['subject'] }}</div>
                                <div class="text-sm text-gray-500">{{ $class['class'] }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2.5 mr-3">
                                        <div class="h-2.5 rounded-full 
                                            {{ $class['attendance'] >= 85 ? 'bg-green-500' : 
                                               ($class['attendance'] >= 70 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                            style="width: {{ $class['attendance'] }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $class['attendance'] }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $class['marks'] }}%</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium {{ $class['pending'] > 5 ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $class['pending'] }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection