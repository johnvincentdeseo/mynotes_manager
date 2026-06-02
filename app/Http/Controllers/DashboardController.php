<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        $totalUsers = User::count();
        $totalNotes = Note::count();
        $myNotesCount = $user ? $user->notes()->count() : 0;
        
        $thisMonthNotes = Note::whereMonth('created_at', Carbon::now()->month)
                              ->whereYear('created_at', Carbon::now()->year)
                              ->count();

        
        $chartData = Note::where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('count', 'date')
            ->toArray();

        
        $labels = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateString = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::now()->subDays($i)->format('M d');
            $counts[] = $chartData[$dateString] ?? 0;
        }

        
        return view('dashboard', compact(
            'totalUsers', 
            'totalNotes', 
            'myNotesCount', 
            'thisMonthNotes', 
            'labels', 
            'counts'
        ));
    }
}