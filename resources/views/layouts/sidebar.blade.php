<aside class="w-64 bg-white border-r min-h-screen">
    <div class="p-4 font-bold text-lg">
        Campus Utility
    </div>

    <nav class="px-4 space-y-2">

        {{-- Common --}}
        <a href="/dashboard" class="block p-2 hover:bg-gray-200 rounded">Dashboard</a>

        {{-- Admin --}}
        @if(auth()->user()->role === 'admin')
            <a href="/timetables" class="block p-2">Timetable</a>
            <a href="/notices" class="block p-2">Notices</a>
            <a href="/fees" class="block p-2">Fees</a>
        @endif

        {{-- Teacher --}}
        @if(auth()->user()->role === 'teacher')
            <a href="/attendance" class="block p-2">Mark Attendance</a>
            <a href="/assignments" class="block p-2">Assignments</a>
            <a href="/quizzes" class="block p-2">Quizzes</a>
        @endif

        {{-- Student --}}
        @if(auth()->user()->role === 'student')
            <a href="/attendance" class="block p-2">My Attendance</a>
            <a href="/assignments" class="block p-2">Assignments</a>
            <a href="/quizzes" class="block p-2">My Quizzes</a>
        @endif

    </nav>
</aside>
