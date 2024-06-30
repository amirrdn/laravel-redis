<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\DailyRecord;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::where(function ($query) use ($search) {
            $query->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $search . '%')
                  ->orWhere('age', 'like', '%' . $search . '%')
                  ->orWhere('gender', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')->paginate(10);

        $totalUsers = User::count();
        // echo '<pre>';
        // print_r($users);
        // echo '</pre>';
        return view('users.index', compact('users', 'totalUsers', 'search'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        $this->updateDailyRecordCounts($user->gender);

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    private function updateDailyRecordCounts($gender)
    {
        $dailyRecord = DailyRecord::whereDate('date', today())->first();

        if ($dailyRecord) {
            if ($gender === 'male') {
                $dailyRecord->decrement('male_count');
            } elseif ($gender === 'female') {
                $dailyRecord->decrement('female_count');
            }
        }
    }
    public function dailyRecords()
    {
        $dailyRecords = DailyRecord::orderBy('date', 'desc')->get();

        return view('users.daily_records', compact('dailyRecords'));
    }
}
