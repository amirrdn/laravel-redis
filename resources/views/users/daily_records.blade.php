@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4">Daily Record Report</h1>

        <table class="min-w-full bg-white border rounded-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Male Avg Count</th>
                    <th class="px-4 py-2">Female Avg Count</th>
                    <th class="px-4 py-2">Male Avg Age</th>
                    <th class="px-4 py-2">Female Avg Age</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailyRecords as $dailyRecord)
                    <tr>
                        <td class="border px-4 py-2">{{ $dailyRecord->date }}</td>
                        <td class="border px-4 py-2">{{ $dailyRecord->male_count }}</td>
                        <td class="border px-4 py-2">{{ $dailyRecord->female_count }}</td>
                        <td class="border px-4 py-2">{{ $dailyRecord->male_avg_age }}</td>
                        <td class="border px-4 py-2">{{ $dailyRecord->female_avg_age }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection