@extends('layouts.app')

@section('title', 'My Attendance')

@php
$pageTitle = 'My Attendance';
$pageSubtitle = 'View your attendance records for all subjects';
@endphp

@section('content')
<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Overall Attendance</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ number_format($overallPercentage ?? 0, 1) }}%
                    </p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Classes Attended</p>
                    <p class="text-2xl font-bold">{{ $totalAttended ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-red-100 text-red-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Classes Missed</p>
                    <p class="text-2xl font-bold">{{ $totalMissed ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Subject-wise Attendance</h3>
                <span class="text-sm text-gray-500">Last Updated: {{ now()->format('M d, Y') }}</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subject
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Classes
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Attended
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Missed
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Percentage
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendances as $attendance)
                    @php
                    $missed = $attendance->total_classes - $attendance->attended;
                    $percentage = $attendance->total_classes > 0 ? ($attendance->attended / $attendance->total_classes) * 100 : 0;

                    $statusColor = $percentage >= 75 ? 'bg-green-100 text-green-800' :
                    ($percentage >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                    $statusText = $percentage >= 75 ? 'Good' :
                    ($percentage >= 50 ? 'Average' : 'Low');
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-blue-600 font-bold text-sm">
                                        {{ strtoupper(substr($attendance->subject->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $attendance->subject->name }}
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $attendance->total_classes }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $attendance->attended }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-red-600 font-medium">{{ $missed }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mr-3">
                                    <!-- <div class="h-2.5 rounded-full 
                                        {{ $percentage >= 75 ? 'bg-green-500' : 
                                           ($percentage >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                        style="width: {{ min($percentage, 100) }}%">
                                    </div> -->
                                </div>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ number_format($percentage, 1) }}%
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                {{ $statusText }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-gray-500 text-lg">No attendance records found.</p>
                                <p class="text-gray-400 mt-2">Your attendance will appear here once marked by your teacher.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attendances->count() > 0)
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Showing <span class="font-medium">{{ $attendances->count() }}</span> subjects
                </div>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Export as PDF
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Print Report
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Attendance Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Attendance Tips -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <h4 class="text-lg font-semibold mb-4">Attendance Tips</h4>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Aim for 75%+ attendance for good academic standing</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Regular attendance improves learning and grades</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Contact your teacher if you need to miss classes</span>
                </li>
            </ul>
        </div>

        <!-- Recent Attendance Trends -->
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Attendance Trends</h4>
            <div class="space-y-4">
                @php
                $trends = [
                ['subject' => 'Mathematics', 'change' => '+5%', 'direction' => 'up', 'color' => 'text-green-600'],
                ['subject' => 'Physics', 'change' => '+2%', 'direction' => 'up', 'color' => 'text-green-600'],
                ['subject' => 'Chemistry', 'change' => '-3%', 'direction' => 'down', 'color' => 'text-red-600'],
                ];
                @endphp
                @foreach($trends as $trend)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                            <span class="text-gray-600 font-bold">{{ strtoupper(substr($trend['subject'], 0, 1)) }}</span>
                        </div>
                        <span class="text-gray-700">{{ $trend['subject'] }}</span>
                    </div>
                    <div class="flex items-center {{ $trend['color'] }}">
                        @if($trend['direction'] === 'up')
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        @else
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        @endif
                        <span class="font-medium">{{ $trend['change'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection