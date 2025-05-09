<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class DashboardController extends Controller
{

   /* public function index()
    {
    $mostCorrectlyAnsweredQuestion = laravelll::table('participant_answer')
        ->where('mark', 1)
        ->groupBy('question_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->select('question_id', laravelll::raw('COUNT(*) as correct_answers'))
        ->first();

        return view('pages.dashboard',compact('mostCorrectlyAnsweredQuestion'));
    }*/

    public function showAnalytics($challengeId=null){
        // get the scores of each participant and sum them by school
        $schoolScores = table_school_representative::join('participantsChallenge', 'participants.id','=','attempts.participant_id')
        ->select('participants.school_regNo', DB::raw('SUM(attempts.score) as total_score'))
        ->groupBy('participants.school_regNo')
        ->orderBy('total_score','desc')
        ->get();
        
        
        // get the school details
        $rankedSchools = $school_representative->map(function ($schoolScore){
            $school = Schools::find($schoolScore->school_id);
            return[
                'school_name'=> $school->name,
                'district'=> $school->district,
                'total_score'=> $schoolScore->total_score
            ];
        });




    $mostCorrectlyAnsweredQuestions = DB::table('question')
    ->join('participant_answer','question.id','=','participant_answer.participant_challenge_id')
    ->select('question.question', DB::raw('COUNT(answers.is_correct) as correct_count'))//selects the question text and the count of correct answers.
    ->where('answers.is_correct', true)//filters only the correct answers
    ->groupBy('question.id', 'question.question_text')//groups by both the question ID and the question text 
    ->orderBy('correct_count','desc')//orders the results by the count of correct answers in descending order.
    ->get();



    $schoolPerformanceOverTime = DB::table('participant_challenge')
    ->join('participant','participant_challenge.participant_id','=','participant.id')
    ->join('school_representative','participant.school_id','=','table_schools.id')
    ->select('school_representative.name', DB::raw('YEAR(participant_challenge.created_at) as year'), DB::raw('SUM(scores.score) as total_score')) 
    ->groupBy('school_repraentative.name','year')
    ->orderBy('year','asc') 
    -> get();

    //fetch performance data for graphs
    $participantPerformanceOverTime = DB::table('participant_challenge')
    ->join('participant','participant_challenge.participant_id','=','participant.id')
    ->select('participant.username', DB::raw('YEAR(participant_challenge.created_at) as year'), DB::raw('SUM(participant_challenge.score) as total_score'))
    ->groupBy('participant.username','year') 
    ->orderBy('year','asc') 
    ->get();


    // calculate question repetition percentage for each participant
    $participant = DB::table('participant')->get();
    $participantRepetitions = [];

    foreach ($participants as $participant) {
        $attempts= DB::table('particiantChallenge')
        ->where('participant_id',  $participant -> id)
        ->pluck('questions_attempted');


        $allQuestions = [];
        foreach ($attempts as $attempt){
            $questions=json_decode($attempt);
            if($questions){
                $allQuestions= array_merge($allQuestions, $questions);
            }
        }

        $questionCounts= array_count_values($allQuestions);
        $totalQuestions= count($allQuestions);
        $repeatedQuestions= 0;


        foreach($questionCounts as $count){
            if($count > 1){
                $repeatedQuestions += ($count - 1);
        }
    }


    $repetitionPercentage = 0;
    if($totalQuestions > 0){
        $repetitionPercentage = ($repeatedQuestions / $totalQuestions) *100;
    }


    $participantRepetitions[] = [
        'participant_id'=> $participant->id,
        'username'=> $participant->username,
        'repetition_percentage'=> $repetitionPercentage,
    ];
}



        return view('Dashboard', compact('mostCorrectlyAnsweredQuestions', 'rankedSchools', 'schoolPerformanceOverTime', 'participantPerformanceOverTime', 'participantRepetitions',)); //pass the data to the view
        
}
    

public function index()
{
$mostCorrectlyAnsweredQuestion = DB::table('question')
->whereIn('question_id', function($query) {
$query->select('question_id')
->from(function($sub) {
$sub->select('question_id', DB::raw('COUNT(answer)'))
->from('participant_answer')
->where('marks', '>', 0)
->whereIn('participant_challenge_id', function($subQuery) {
$subQuery->select('participant_challenge_id')
->from('participant_challenge')
->whereIn('challenge_id', function($innerQuery) {
$innerQuery->select('challenge_id')
->from('challenge')
->where('challenge_name', '=', 'trees');
});
})
->groupBy('question_id')
->orderByRaw('COUNT(answer) DESC')
->limit(1)
->toSql();
}, 't1');
})
->first();

Log::info('Most correctly answered question: ' . json_encode($mostCorrectlyAnsweredQuestion));
    $mostCorrectlyAnsweredQuestion=34;

    return view('pages.dashboard', compact('mostCorrectlyAnsweredQuestion'));
}

}
