@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Campus Utility Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="/timetable" class="bg-blue-500 text-white p-4 rounded">Timetable</a>
        <a href="/gpa" class="bg-green-500 text-white p-4 rounded">GPA Calculator</a>
        <a href="/attendance" class="bg-yellow-500 text-white p-4 rounded">Attendance</a>
        <a href="/notice" class="bg-purple-500 text-white p-4 rounded">Notices</a>
        <a href="/fee" class="bg-red-500 text-white p-4 rounded">Fees</a>
    </div>
</div>
@endsection
