@extends('layouts.app')

@section('title', 'Assignment Upload')

@php
$pageTitle = 'Upload Assignment';
$pageSubtitle = 'Submit your work for this assignment';
@endphp

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">

        <h2 class="text-2xl font-bold mb-4">{{ $assignment->title }}</h2>
        <p class="text-gray-600 mb-4">{{ $assignment->description }}</p>
        <p class="text-sm text-gray-500 mb-6">
            Due Date: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M, Y') }}
        </p>

        {{-- Success/Error messages --}}
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
        @endif

        {{-- Upload Form --}}
        <form action="{{ route('student.assignments.upload', $assignment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Choose File</label>
                <input type="file" name="file" id="file" required class="w-full border rounded px-4 py-2">
                @error('file')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks (Optional)</label>
                <textarea name="remarks" id="remarks" rows="3" class="w-full border rounded px-4 py-2" placeholder="Any comments or notes..."></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('student.assignments') }}" class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Upload</button>
            </div>
        </form>
    </div>
</div>
@endsection