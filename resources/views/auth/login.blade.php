@extends('layouts.app')

@section('content')
    <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" required autofocus
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Login
            </button>
        </form>
    </div>
@endsection