<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Question;
use App\Models\Admin;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionImport;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class ChallengeController extends Controller
{
    public function create()
{

    $challenge = new Challenge(); // Create a new Challenge instance

    return view('pages.challenge-creation', compact( 'challenge'));
}

        public function index()
        {
            $allChallenges = Challenge::all(); // Retrieve all challenges
            return view('pages.challenge-index', compact('allChallenges'));
        }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'admin_id' => 'required|in:' . Auth::guard('admin')->id(),
            'challenge_name' => 'required|string|max:255|unique:challenge',
            'challenge_description' => 'required|string|max:255',
            'challenge_start_date' => 'required|date',
            'challenge_end_date' => 'required|date|after:start_date',
            'duration' => 'required|integer',
            'wrong_answer_marks' => 'required|integer',
            'blank_answer_marks' => 'required|integer',
            'questions_to_answer' => 'required|integer',
            'question_document' => 'required|file|mimes:xlsx,xls',
            'answer_document' => 'required|file|mimes:xlsx,xls',
        ]);

        $challenge = new Challenge();
        $challenge->challenge_name = $validatedData['challenge_name'];
        $challenge->challenge_description = $validatedData['challenge_description'];
        $challenge->challenge_start_date = $validatedData['challenge_start_date'];
        $challenge->challenge_end_date = $validatedData['challenge_end_date'];
        $challenge->duration = $validatedData['duration'];

        $challenge->wrong_answer_marks = $validatedData['wrong_answer_marks'];
        $challenge->blank_answer_marks = $validatedData['blank_answer_marks'];
        $challenge->questions_to_answer = $validatedData['questions_to_answer'];


        $challenge->admin_id = Auth::guard('admin')->id();
        $challenge->save();

        $questions = $request->file('question_document');
        $answers = $request->file('answer_document');

        $questionDocumentPath = $questions->store('challenges', 'public');
        $challenge->question_document = $questionDocumentPath;

        // Store answer document
        $answerDocumentPath = $answers->store('challenges', 'public');
        $challenge->answer_document = $answerDocumentPath;


        // Get the ID of the newly created challenge
        $challengeId = $challenge->id;

        // Process and import questions and answers
        DB::beginTransaction();
        try {

            $questionImport=new QuestionImport($questions,$answers,$challengeId);





            DB::commit();

            // After successful import, check the count
            $questionCount = Question::where('challenge_id', $challengeId)->count();

            Log::info("After import: {$questionCount} questions and answers in database for challenge #{$challengeId}");

            return back()->with('success', 'Challenge created and questions and answers uploaded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while importing questions and answers.');
        }
    }


}




