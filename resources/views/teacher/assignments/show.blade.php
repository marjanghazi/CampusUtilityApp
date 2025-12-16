@extends('layouts.app')

@section('title', 'Assignment Submissions')

@php
$pageTitle = 'Assignment Submissions';
$pageSubtitle = 'View all submissions from students';
@endphp

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">

        <h2 class="text-2xl font-bold mb-4">{{ $assignment->title }}</h2>
        <p class="text-gray-600 mb-6">{{ $assignment->description }}</p>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($submissions as $submission)
                        <tr>
                            <td class="px-6 py-4">{{ $submission->student->name }}</td>
                            <td class="px-6 py-4">{{ $submission->student->email }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                    Download
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $submission->remarks ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $submission->created_at->format('d M, Y H:i') }}</td>
                            <td class="px-6 py-4">
                                {{-- Optional: Grade or mark submission --}}
                                <a href="{{ route('teacher.submissions.grade', $submission->id) }}" class="text-green-600 hover:underline">Grade</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                No submissions yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
