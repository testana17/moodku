<?php
namespace App\Http\Controllers;

use App\Enums\MoodType;
use App\Models\Mood;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MoodController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mood' => ['required', 'string', 'in:happy,sad,angry,calm,anxious,excited,tired,neutral'],
            'note' => 'nullable|string',
            'date' => 'required|date',
        ]);
        Mood::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'date' => $request->date,
            ],
            [
                'mood' => $request->mood,
                'note' => $request->note,
            ]
        );

        return redirect()->back()->with('success', 'Mood recorded successfully!');
    }

    public function index(Request $request): Response
    {
        return Inertia::render('MoodIndex', [
            'user' => $request->user(),
            'moods' => Mood::where('user_id', $request->user()->id)->get(),
        ]);
    }
    

    public function calendar()
    {
        $moods = Mood::where('user_id', auth()->id())->get();
        return Inertia::render('MoodCalender', ['moods' => $moods]);
    }
}
