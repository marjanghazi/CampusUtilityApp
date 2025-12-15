<header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold">
        Dashboard
    </h1>

    <div class="flex items-center gap-4">
        <span>{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-600">Logout</button>
        </form>
    </div>
</header>
