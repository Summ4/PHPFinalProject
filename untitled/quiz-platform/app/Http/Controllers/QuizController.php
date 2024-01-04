<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::orderBy('created_at', 'desc')->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function show($id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('quizzes.show', compact('quiz'));
    }

    public function create()
    {
        $this->authorize('create', Quiz::class);

        return view('quizzes.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Quiz::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $quiz = auth()->user()->quizzes()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'main_photo' => $request->file('main_photo') ? $request->file('main_photo')->store('quiz_photos', 'public') : null,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $this->authorize('update', $quiz);

        return view('quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $this->authorize('update', $quiz);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $quiz->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'main_photo' => $request->file('main_photo') ? $request->file('main_photo')->store('quiz_photos', 'public') : $quiz->main_photo,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $this->authorize('delete', $quiz);

        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    public function publish($id)
    {
        $quiz = Quiz::findOrFail($id);
        $this->authorize('publish', $quiz);

        $quiz->update(['published' => true]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz published successfully.');
    }
}
