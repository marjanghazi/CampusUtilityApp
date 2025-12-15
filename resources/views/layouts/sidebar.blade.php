{{-- resources/views/components/sidebar.blade.php --}}
<aside class="w-64 bg-gradient-to-b from-gray-50 to-white border-r border-gray-200 min-h-screen shadow-lg">
    <!-- Logo Section -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">CU</span>
            </div>
            <div>
                <h1 class="font-bold text-xl text-gray-800">Campus Utility</h1>
                <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }} Portal</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="p-4 space-y-1">
        <!-- Common: Dashboard (Always Visible) -->
        <div class="pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">General</p>
        </div>
        <a href="/dashboard"
            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group {{ request()->is('dashboard') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <!-- Admin Section -->
        @if(auth()->user()->role === 'admin')
        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Administration</p>
        </div>

        <a href="/timetables"
            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group {{ request()->is('timetables*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Timetable
        </a>

        <a href="/notices"
            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group {{ request()->is('notices*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            Notices
        </a>

        <a href="/fees"
            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group {{ request()->is('fees*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Fees
        </a>
        @endif

        <!-- Teacher Section -->
        {{-- In sidebar.blade.php --}}
        {{-- Teacher Section --}}
        @if(auth()->user()->role === 'teacher')
        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Teaching</p>
        </div>

        <a href="{{ route('attendance.index') }}"
            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group {{ request()->is('teacher/attendance*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Mark Attendance
        </a>

        {{-- ... other teacher links --}}
        @endif

        {{-- Student Section --}}
        @if(auth()->user()->role === 'student')
        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">My Activities</p>
        </div>

        <a href="{{ route('student.attendance') }}"
            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group {{ request()->is('student/attendance*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            My Attendance
        </a>

        <a href="{{ route('student.assignments') }}"
            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group {{ request()->is('student/assignments*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Assignments
        </a>

        <a href="{{ route('student.quizzes') }}"
            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group {{ request()->is('student/quizzes*') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            My Quizzes
        </a>
        @endif

        <!-- Show ALL links for ALL roles (Alternative version if you want to see all pages) -->
        {{--
        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">All Pages</p>
        </div>
        
        <!-- Admin Pages -->
        @if(auth()->user()->role === 'admin')
        <a href="/timetables" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group">Timetable</a>
        <a href="/notices" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group">Notices</a>
        <a href="/fees" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group">Fees</a>
        @endif
        
        <!-- Teacher Pages -->
        @if(auth()->user()->role === 'teacher')
        <a href="/attendance" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group">Mark Attendance</a>
        <a href="/assignments" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group">Assignments</a>
        <a href="/quizzes" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group">Quizzes</a>
        @endif
        
        <!-- Student Pages -->
        @if(auth()->user()->role === 'student')
        <a href="/attendance" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group">My Attendance</a>
        <a href="/assignments" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group">Assignments</a>
        <a href="/quizzes" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 group">My Quizzes</a>
        @endif
        --}}

    </nav>

    <!-- User Info at Bottom -->
    <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200">
        <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                <span class="text-blue-600 font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
        </div>
    </div>
</aside>