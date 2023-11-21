<footer class="mt-4 p-2 bg-light">
    <div class="text-center">
        @auth
            <p>User logged in</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @else
            <p>User not logged in</p>
        @endauth
    </div>
</footer>