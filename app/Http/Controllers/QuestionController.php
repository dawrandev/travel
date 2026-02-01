<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $query = Question::with('tour.translations');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_primary', 'like', "%{$search}%")
                  ->orWhere('phone_secondary', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $questions = $query->orderBy('created_at', 'desc')->paginate(15);

        // AJAX request
        if ($request->ajax()) {
            return view('pages.questions.table', compact('questions'))->render();
        }

        return view('pages.questions.index', compact('questions'));
    }

    public function show(int $id)
    {
        $question = Question::with('tour.translations')->findOrFail($id);
        return response()->json($question);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,answered'
        ]);

        $question = Question::findOrFail($id);
        $question->update(['status' => $request->status]);

        return redirect()->route('questions.index')->with('success', 'Статус вопроса обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Вопрос успешно удален');
    }
}

