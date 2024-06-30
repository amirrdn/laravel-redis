@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4">Users</h1>

        <form action="{{ route('users.index') }}" method="GET" class="mb-4">
            <div class="flex items-center">
                <input type="text" name="search" placeholder="Search by name" class="px-4 py-2 border rounded-md mr-2">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
            </div>
        </form>

        <p class="mb-4">Total Users: {{ $totalUsers }}</p>

        <table class="min-w-full bg-white border rounded-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Age</th>
                    <th class="px-4 py-2">Gender</th>
                    <th class="px-4 py-2">Created At</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user->first_name." ". $user->last_name }}</td>
                        <td class="border px-4 py-2">{{ $user->age }}</td>
                        <td class="border px-4 py-2">{{ $user->gender }}</td>
                        <td class="border px-4 py-2">{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="border px-4 py-2">
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection