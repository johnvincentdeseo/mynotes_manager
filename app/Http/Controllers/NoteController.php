<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NoteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notes = $user->notes()->latest()->get();

        // ---- CHART DATA AGGREGATION ----
        // Get note creation counts grouped by date for the last 7 days
        $chartData = $user->notes()
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('count', 'date')
            ->toArray();

        // Fill in missing days with 0 counts so chart lines don't break
        $labels = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateString = Carbon::now()->subDays($i)->format('Y-m-d');
            $displayLabel = Carbon::now()->subDays($i)->format('M d');
            
            $labels[] = $displayLabel;
            $counts[] = $chartData[$dateString] ?? 0;
        }

        return view('management.notes', compact('notes', 'labels', 'counts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Auth::user()->notes()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')->with('toast_success', 'Note created successfully!');
    }

    public function update(Request $request, Note $note)
    {
        // Security check: ensure user owns the note
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')->with('toast_success', 'Note updated successfully!');
    }

    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index')->with('toast_success', 'Note deleted safely!');
    }
}