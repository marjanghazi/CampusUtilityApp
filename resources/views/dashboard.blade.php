<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @if(auth()->user()->role === 'admin')
        <a href="/timetable" class="bg-blue-500 text-white p-4 rounded">Timetable</a>
        <a href="/notice" class="bg-purple-500 text-white p-4 rounded">Notices</a>
        <a href="/fee" class="bg-red-500 text-white p-4 rounded">Fees</a>
    @elseif(auth()->user()->role === 'teacher')
        <a href="/attendance" class="bg-yellow-500 text-white p-4 rounded">Mark Attendance</a>
        <a href="/assignment" class="bg-green-500 text-white p-4 rounded">Assignments</a>
        <a href="/quiz" class="bg-purple-500 text-white p-4 rounded">Quizzes</a>
    @elseif(auth()->user()->role === 'student')
        <a href="/attendance" class="bg-yellow-500 text-white p-4 rounded">View Attendance</a>
        <a href="/assignment" class="bg-green-500 text-white p-4 rounded">Assignments</a>
        <a href="/quiz" class="bg-purple-500 text-white p-4 rounded">Quizzes</a>
    @endif
</div>
