@extends('layouts.app')

@section('title', 'My Assignments')

@php
    $pageTitle = 'My Assignments';
    $pageSubtitle = 'View and submit your assignments';
@endphp

@section('content')
<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Assignments</p>
                    <p class="text-3xl font-bold mt-2">{{ $assignments->count() }}</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Submitted</p>
                    <p class="text-2xl font-bold">
                        {{ $assignments->filter(fn($a) => $a->submissions->isNotEmpty())->count() }}
                    </p>
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
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold">
                        {{ $assignments->filter(fn($a) => $a->submissions->isEmpty() && !$a->is_overdue)->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignments Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">All Assignments</h3>
                <div class="flex space-x-2">
                    <select class="border rounded-lg px-3 py-2 text-sm">
                        <option>All Subjects</option>
                        <option>Mathematics</option>
                        <option>Physics</option>
                        <option>Chemistry</option>
                    </select>
                    <select class="border rounded-lg px-3 py-2 text-sm">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Submitted</option>
                        <option>Graded</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Assignment
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subject
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Due Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Marks
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assignments as $assignment)
                    @php
                        $submission = $assignment->submissions->first();
                        $isSubmitted = $submission !== null;
                        $isGraded = $isSubmitted && $submission->marks !== null;
                        
                        // Determine status badge
                        if ($assignment->is_overdue && !$isSubmitted) {
                            $statusColor = 'bg-red-100 text-red-800';
                            $statusText = 'Overdue';
                        } elseif ($isGraded) {
                            $statusColor = 'bg-green-100 text-green-800';
                            $statusText = 'Graded';
                        } elseif ($isSubmitted) {
                            $statusColor = 'bg-blue-100 text-blue-800';
                            $statusText = 'Submitted';
                        } else {
                            $statusColor = 'bg-yellow-100 text-yellow-800';
                            $statusText = 'Pending';
                        }
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $assignment->title }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">{{ $assignment->description }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                {{ $assignment->subject }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $assignment->due_date->format('M d, Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $assignment->due_date->format('h:i A') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($isGraded)
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $submission->marks }}/{{ $assignment->total_marks }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ number_format(($submission->marks / $assignment->total_marks) * 100, 1) }}%
                                </div>
                            @elseif($isSubmitted)
                                <span class="text-sm text-gray-500">Awaiting grade</span>
                            @else
                                <span class="text-sm text-gray-500">--</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('student.assignments.show', $assignment->id) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                @if(!$isSubmitted || $assignment->is_overdue)
                                <a href="{{ route('student.assignments.show', $assignment->id) }}" 
                                   class="text-green-600 hover:text-green-900 flex items-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <span class="ml-1 text-xs">Submit</span>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500 text-lg">No assignments yet.</p>
                                <p class="text-gray-400 mt-2">Your teachers will post assignments here.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($assignments->count() > 0)
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Showing <span class="font-medium">{{ $assignments->count() }}</span> assignments
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Submission Summary</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $stats = [
                    ['label' => 'On Time', 'count' => $assignments->filter(fn($a) => $a->submissions->isNotEmpty() && !$a->is_overdue)->count(), 'color' => 'bg-green-500'],
                    ['label' => 'Late', 'count' => $assignments->filter(fn($a) => $a->submissions->isNotEmpty() && $a->is_overdue)->count(), 'color' => 'bg-red-500'],
                    ['label' => 'Graded', 'count' => $assignments->filter(fn($a) => $a->submissions->isNotEmpty() && $a->submissions->first()->marks !== null)->count(), 'color' => 'bg-blue-500'],
                    ['label' => 'Pending', 'count' => $assignments->filter(fn($a) => $a->submissions->isEmpty())->count(), 'color' => 'bg-yellow-500'],
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="text-center p-4 border rounded-lg">
                <div class="text-2xl font-bold text-gray-800">{{ $stat['count'] }}</div>
                <div class="text-sm text-gray-600 mt-1">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection