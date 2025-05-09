<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Analytics extends Model
{use HasFactory;
//    this class shall run queries for analytics from the database

// method to return number of schools in school_representative table
    public function getSchoolsCount(){
        return DB::table('school_representative')->count();
    }
// method to return number of challenges in challenge table
    public function getChallengesCount(){
        return DB::table('challenge')->count();
    }
// method to return number of participants in participant table
    public function getParticipantsCount(){
        return DB::table('participant')->count();
    }

    // method to return the most correctly answered question in a challenge
    public function getMostCorrectlyAnswered($challengeName) {
        return DB::table('question')
            ->select('question')
            ->whereIn('question_id', function($query) use ($challengeName) {
                $query->select('question_id')
                    ->from(function($sub) use ($challengeName) {
                        $sub->select('question_id', DB::raw('COUNT(answer)'))
                            ->from('participant_answer')
                            ->where('marks', '>', 0)
                            ->whereIn('participant_challenge_id', function($subQuery) use ($challengeName) {
                                $subQuery->select('participant_challenge_id')
                                    ->from('participant_challenge')
                                    ->whereIn('challenge_id', function($innerQuery) use ($challengeName) {
                                        $innerQuery->select('challenge_id')->from('challenge')->where('challenge_name', '=', $challengeName);
                                    });
                            })
                            ->groupBy('question_id')
                            ->orderByRaw('COUNT(answer) DESC')
                            ->limit(1)
                            ->toSql();
                    }, 't1');
            })
            ->first();
    }
    //method to return number of challenge attempts in the whole system
    public function getChallengeAttempts(){
        return DB::table('participant_challenge')->count();
    }

    //a method to return an array containing challenge names and the  total attempts for each challenge in the system
    public function getChallengeAttemptsByChallenge(){
        return DB::table('challenge')
            ->select('challenge_name', DB::raw('COUNT(participant_challenge_id) as total_attempts'))
            ->leftJoin('participant_challenge', 'challenge.challenge_id', '=', 'participant_challenge.challenge_id')
            ->groupBy('challenge.challenge_id','challenge_name')
            ->get();
    }

    //a method to return a 2 dimensional array containing the raking of schools per challenge with school name, percentage score out of a total of 10 and the average score of each challenge attempt for students from each school
    //the inner arrays should contain the school name,challenge name, average percentage score of participants from the school and average score of participants per challenge

    public function getSchoolsRankingPerChallengeUsingSchoolRegNo() {
        $schools = DB::table('school_representative')->get();
        $challenges = DB::table('challenge')->get();
        $results = [];

        foreach ($schools as $school) {
            foreach ($challenges as $challenge) {
                $totalMarks = DB::table('participant_challenge')
                    ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                    ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                    ->where('participant.schoolRegNo', $school->school_regNo)
                    ->where('challenge.challenge_id', $challenge->challenge_id)
                    ->sum('score');

                $totalAttempts = DB::table('participant_challenge')
                    ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                    ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                    ->where('participant.schoolRegNo', $school->school_regNo)
                    ->where('challenge.challenge_id', $challenge->challenge_id)
                    ->count();

                $averageScore = $totalAttempts > 0 ? $totalMarks / $totalAttempts : 0;
                $percentageScore = ($averageScore / 10) * 100; // Assuming total possible score is 10

                $results[] = [
                    'school_name' => $school->school_name,
                    'average_percentage_score' => $percentageScore,
                    'average_score' => $averageScore,
                    'district'=> $school->school_district,
                    //get school district


                ];
                //log the results
                \Log::info('School: ' . $school->school_name . ' Challenge: ' . $challenge->challenge_name . ' Average Score: ' . $averageScore . ' Percentage Score: ' . $percentageScore . $school->school_district);

            }
        }
//log the results
        \Log::info('Results: ' . json_encode($results));
        return $results;
    }

//get the top 5 schools given a challenge name
    public function getTop5SchoolsPerChallenge($challengeName) {
        $schools = DB::table('school_representative')->get();
        $questionsToAttempt=DB::table('challenge')->select('questions_to_answer')->where('challenge_name',$challengeName)->first();

        $results = [];

        foreach ($schools as $school) {
            $totalMarks = DB::table('participant_challenge')
                ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                ->where('participant.schoolRegNo', $school->school_regNo)
                ->where('challenge.challenge_name', $challengeName)
                ->sum('score');

            $totalAttempts = DB::table('participant_challenge')
                ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                ->where('participant.schoolRegNo', $school->school_regNo)
                ->where('challenge.challenge_name', $challengeName)
                ->count();

            $averageScore = $totalAttempts > 0 ? $totalMarks / $totalAttempts : 0;
            $percentageScore = ($averageScore / ($questionsToAttempt->questions_to_answer)) * 100; // Assuming total possible score is 10
            //cast as int
            $percentageScore = (int)$percentageScore;
            $averageScore = (int)$averageScore;

            $results[] = [
                'school_name' => $school->school_name,
                'average_percentage_score' => $percentageScore,
                'average_score' => $averageScore,
                'district' => $school->school_district,
            ];
        }

        // Sort the results by average percentage score in descending order
        usort($results, function($a, $b) {
            return $b['average_percentage_score'] - $a['average_percentage_score'];
        });

        // Return only the top 5 schools
        return array_slice($results, 0, 5);
    }

    //get bottom 5 schools given a challenge name
    public function getBottom5SchoolsPerChallenge($challengeName) {
        $schools = DB::table('school_representative')->get();
        $results = [];
//        $questionsToAttempt=DB::table('challenge')->get()->where('challenge_name',$challengeName);
        $questionsToAttempt=DB::table('challenge')->select('questions_to_answer')->where('challenge_name',$challengeName)->first();
        foreach ($schools as $school) {
            $totalMarks = DB::table('participant_challenge')
                ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                ->where('participant.schoolRegNo', $school->school_regNo)
                ->where('challenge.challenge_name', $challengeName)
                ->sum('score');

            $totalAttempts = DB::table('participant_challenge')
                ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                ->where('participant.schoolRegNo', $school->school_regNo)
                ->where('challenge.challenge_name', $challengeName)
                ->count();

            $averageScore = $totalAttempts > 0 ? $totalMarks / $totalAttempts : 0;
            $percentageScore = ($averageScore / ($questionsToAttempt->questions_to_answer)) * 100; // Assuming total possible score is 10
            //cast as int
            $percentageScore = (int)$percentageScore;
            $averageScore = (int)$averageScore;

            $results[] = [
                'school_name' => $school->school_name,
                'average_percentage_score' => $percentageScore,
                'average_score' => $averageScore,
                'district' => $school->school_district,
            ];
        }

        // Sort the results by average percentage score in ascending order
        usort($results, function($a, $b) {
            return $a['average_percentage_score'] - $b['average_percentage_score'];
        });

        // Return only the bottom 5 schools
        return array_slice($results, 0, 5);
    }
    //return array of challenge names
    public function getChallenges(){
        return DB::table('challenge')->select('challenge_name')->get();
    }

    public function getTop5Schools()
    {
        $schools = DB::table('school_representative')->get();
        $challenges = DB::table('challenge')->get();
        $schoolScores = [];

        foreach ($schools as $school) {
            $totalPercentageScore = 0;
            $challengesCount = 0;

            foreach ($challenges as $challenge) {
                $totalMarks = DB::table('participant_challenge')
                    ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                    ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                    ->where('participant.schoolRegNo', $school->school_regNo)
                    ->where('challenge.challenge_id', $challenge->challenge_id)
                    ->sum('score');

                $totalAttempts = DB::table('participant_challenge')
                    ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                    ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                    ->where('participant.schoolRegNo', $school->school_regNo)
                    ->where('challenge.challenge_id', $challenge->challenge_id)
                    ->count();

                if ($totalAttempts > 0) {
                    $averageScore = $totalMarks / $totalAttempts;
                    $percentageScore = ($averageScore / $challenge->questions_to_answer) * 100;
                    $totalPercentageScore += $percentageScore;
                    $challengesCount++;
                }
            }

            if ($challengesCount > 0) {
                $averagePercentageScore = $totalPercentageScore / $challengesCount;
                $schoolScores[] = [
                    'school_name' => $school->school_name,
                    'average_percentage_score' => $averagePercentageScore,
                    'district'=>$school->school_district,
                ];
            }
        }

        // Sort schools by average percentage score in descending order
        usort($schoolScores, function ($a, $b) {
            return $b['average_percentage_score'] <=> $a['average_percentage_score'];
        });

        // Get top 5 schools
        return array_slice($schoolScores, 0, 5);
    }


    public function getBottom5Schools()
    {
        $schools = DB::table('school_representative')->get();
        $challenges = DB::table('challenge')->get();
        $schoolScores = [];

        foreach ($schools as $school) {
            $totalPercentageScore = 0;
            $challengesCount = 0;

            foreach ($challenges as $challenge) {
                $totalMarks = DB::table('participant_challenge')
                    ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                    ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                    ->where('participant.schoolRegNo', $school->school_regNo)
                    ->where('challenge.challenge_id', $challenge->challenge_id)
                    ->sum('score');

                $totalAttempts = DB::table('participant_challenge')
                    ->join('participant', 'participant_challenge.participant_id', '=', 'participant.participant_id')
                    ->join('challenge', 'participant_challenge.challenge_id', '=', 'challenge.challenge_id')
                    ->where('participant.schoolRegNo', $school->school_regNo)
                    ->where('challenge.challenge_id', $challenge->challenge_id)
                    ->count();

                if ($totalAttempts > 0) {
                    $averageScore = $totalMarks / $totalAttempts;
                    $percentageScore = ($averageScore / $challenge->questions_to_answer) * 100;
                    $totalPercentageScore += $percentageScore;
                    $challengesCount++;
                }
            }

            if ($challengesCount > 0) {
                $averagePercentageScore = $totalPercentageScore / $challengesCount;
                $schoolScores[] = [
                    'school_name' => $school->school_name,
                    'average_percentage_score' => $averagePercentageScore,
                    'district'=>$school->school_district,
                ];
            }
        }

        // Sort schools by average percentage score in ascending order
        usort($schoolScores, function ($a, $b) {
            return $a['average_percentage_score'] <=> $b['average_percentage_score'];
        });

        // Get bottom 5 schools
        return array_slice($schoolScores, 0, 5);
    }



}
