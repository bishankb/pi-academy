<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QuestionSet;
use App\ExaminationQuestion;
use App\ExaminationResult;
use Auth;
use Cache;
use SEOMeta;
use OpenGraph;

class ExamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:exam');
    }
    
    public function index($set_type)
    {
    	$set = QuestionSet::where('slug', $set_type)->whereHas('questions')->first();

        if(empty($set)) {
            abort(404);
        }

        $marks = ExaminationQuestion::Marks;
        $subjects = ExaminationQuestion::Subjects;

    	$one_mark_questions = ExaminationQuestion::where('question_set_id', $set->id)
                                                    ->where('marks', array_flip($marks)['1 Mark'])
                                                    ->get()
                                                    ->groupBy('subject')
                                                    ->shuffle()
                                                    ->flatten(1);

        $one_mark_questions = Cache::remember('one_mark_questions'.$set->id.Auth::user()->id, config('pi-academy.question_timeout'), function () use ($one_mark_questions) {
            return $one_mark_questions;
        });
                                                    
    	$two_mark_questions = ExaminationQuestion::where('question_set_id', $set->id)
                                                    ->where('marks', array_flip($marks)['2 Marks'])
                                                    ->get()
                                                    ->groupBy('subject')
                                                    ->shuffle()
                                                    ->flatten(1);

        $two_mark_questions = Cache::remember('two_mark_questions'.$set->id.Auth::user()->id, config('pi-academy.question_timeout'), function () use ($two_mark_questions) {
            return $two_mark_questions;
        });

    	$all_questions = ExaminationQuestion::where('question_set_id', $set->id)->get();

        return view('exam.take-exam', compact('set', 'one_mark_questions', 'two_mark_questions', 'all_questions', 'marks', 'subjects'));
    }

    public function check(Request $request, $set_type)
    {
        $this->seoCheck($set_type);

    	$set = QuestionSet::where('slug', $set_type)->first();
        
        if (Cache::has('one_mark_questions'.$set->id.Auth::user()->id)) {
            $cachedOneMarkQuestions = Cache::pull('one_mark_questions'.$set->id.Auth::user()->id);
        } else {
             $notification = array(
                'message'    => 'Session Timeout.',
                'alert-type' => 'error'
            );  
            
            return redirect()->route('exam.home')->with($notification);
        }

        if (Cache::has('two_mark_questions'.$set->id.Auth::user()->id)) {
            $cachedTwoMarkQuestions = Cache::pull('two_mark_questions'.$set->id.Auth::user()->id);
        }
    	
    	$marks = ExaminationQuestion::Marks;
        $subjects = ExaminationQuestion::Subjects;
        $attempted1Mark = 0;
        $attempted2Mark = 0;
    	$correct1Mark = 0;
        $correct2Mark = 0;

        $get_attempted_questions = array_keys($request->except('_token'));
        $get_choosen_answers = array_values($request->except('_token'));

        $all_questions = $cachedOneMarkQuestions->merge($cachedTwoMarkQuestions);

        try {
        	foreach ($all_questions as $key => $all_question) {
	            if (request($all_question->id)) {
	                if ($all_question->marks == array_flip($marks)['1 Mark']) {
	                    if (request($all_question->id) == $all_question->correct_answer) {
	                        $correct1Mark += 1;
	                    }
	                    $attempted1Mark += 1;
	                } elseif ($all_question->marks == array_flip($marks)['2 Marks']) {
	                    if (request($all_question->id) == $all_question->correct_answer) {
	                        $correct2Mark += 1;
	                    }
	                    $attempted2Mark += 1;
	                }
	            }
	        }
			$attempted = $attempted1Mark + $attempted2Mark;
            $incorrect1Marks = $attempted1Mark - $correct1Mark; 
            $incorrect2Marks = $attempted2Mark - $correct2Mark;
            $negative1MarksMarking = $incorrect1Marks * 0.1;
            $negative2MarksMarking = $incorrect2Marks * 0.2;
	        $score = $correct1Mark + 2 * $correct2Mark - $negative1MarksMarking - $negative2MarksMarking;

	        $question_result = ExaminationResult::create(
                [
                    'student_id'          => Auth::user()->id,
                    'question_set_id'     => $set->id,
                    'attempted_1_mark'    => $attempted1Mark,
                    'attempted_2_mark'    => $attempted2Mark,
                    'correct_1_mark'      => $correct1Mark,
                    'correct_2_mark'      => $correct2Mark,
                    'attempted'   	      => $attempted,
                    'score'   		      => $score,
                    'attempted_questions' => $get_attempted_questions,
                    'choosen_answers'     => $get_choosen_answers,
                ]
            );

            $attemptedQuestionOrder = implode(',',$get_attempted_questions);

            if($attemptedQuestionOrder) {
                $attemptedQuestions =  ExaminationQuestion::where('question_set_id', $set->id)->orderBy('marks')
                                                            ->whereIn('id', $get_attempted_questions)
                                                            ->orderByRaw("FIELD(id , $attemptedQuestionOrder) ASC")
                                                            ->get();
            } else {
                 $attemptedQuestions = [];
            }

            $attempted_question_answers = [];

            if(isset($set->paragraph)) {
                $paragraph = $set->paragraph->paragraph;               
            } else {
                $paragraph = null;
            }

            foreach ($attemptedQuestions as $key => $attemptedQuestion) {
                array_push($attempted_question_answers, [
                    'id' => $attemptedQuestion->id,
                    'question' => $attemptedQuestion->question,
                    'choosen_answer' => (int)$get_choosen_answers[$key],
                    'option1' => $attemptedQuestion->option1,
                    'option2' => $attemptedQuestion->option2,
                    'option3' => $attemptedQuestion->option3,
                    'option4' => $attemptedQuestion->option4,
                    'correct_answer' => $attemptedQuestion->correct_answer,
                    'solution' => $attemptedQuestion->solution,
                    'paragraph' => $paragraph,
                    'subject' => $subjects[$attemptedQuestion->subject],
                    'marks' => $marks[$attemptedQuestion->marks]
                ]);
            }

            $total1Aptitude = count($this->totalQuestion($all_questions, '1 Mark', 'Aptitude'));
            $total1Chemistry = count($this->totalQuestion($all_questions, '1 Mark', 'Chemistry'));
            $total1English = count($this->totalQuestion($all_questions, '1 Mark', 'English'));
            $total1Math = count($this->totalQuestion($all_questions, '1 Mark', 'Math'));
            $total1Physics = count($this->totalQuestion($all_questions, '1 Mark', 'Physics'));
            $total1Marks = $total1Aptitude + $total1Chemistry + $total1English + $total1Math + $total1Physics;

            $total2Aptitude = count($this->totalQuestion($all_questions, '2 Marks', 'Aptitude'));
            $total2Chemistry = count($this->totalQuestion($all_questions, '2 Marks', 'Chemistry'));
            $total2English = count($this->totalQuestion($all_questions, '2 Marks', 'English'));
            $total2Math = count($this->totalQuestion($all_questions, '2 Marks', 'Math'));
            $total2Physics = count($this->totalQuestion($all_questions, '2 Marks', 'Physics'));
            $total2Marks = $total2Aptitude + $total2Chemistry + $total2English + $total2Math + $total2Physics;

            $attempted1Aptitude = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'Aptitude'));
            $attempted1Chemistry = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'Chemistry'));
            $attempted1English = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'English'));
            $attempted1Math = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'Math'));
            $attempted1Physics = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'Physics'));

            $attempted2Aptitude = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'Aptitude'));
            $attempted2Chemistry = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'Chemistry'));
            $attempted2English = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'English'));
            $attempted2Math = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'Math'));
            $attempted2Physics = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'Physics'));

            $correct1Aptitude = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'Aptitude'));
            $correct1Chemistry = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'Chemistry'));
            $correct1English = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'English'));
            $correct1Math = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'Math'));
            $correct1Physics = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'Physics'));

            $correct2Aptitude = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'Aptitude'));
            $correct2Chemistry = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'Chemistry'));
            $correct2English = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'English'));
            $correct2Math = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'Math'));
            $correct2Physics = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'Physics'));

            $incorrect1Aptitude = $attempted1Aptitude - $correct1Aptitude; 
            $incorrect1Chemistry = $attempted1Chemistry - $correct1Chemistry; 
            $incorrect1English = $attempted1English - $correct1English; 
            $incorrect1Math = $attempted1Math - $correct1Math; 
            $incorrect1Physics = $attempted1Physics - $correct1Physics; 

            $incorrect2Aptitude = $attempted2Aptitude - $correct2Aptitude; 
            $incorrect2Chemistry = $attempted2Chemistry - $correct2Chemistry; 
            $incorrect2English = $attempted2English - $correct2English; 
            $incorrect2Math = $attempted2Math - $correct2Math; 
            $incorrect2Physics = $attempted2Physics - $correct2Physics; 

            $negative1Aptitude = $incorrect1Aptitude * 0.1; 
            $negative1Chemistry = $incorrect1Chemistry * 0.1; 
            $negative1English = $incorrect1English * 0.1; 
            $negative1Math = $incorrect1Math * 0.1; 
            $negative1Physics = $incorrect1Physics * 0.1; 

            $negative2Aptitude = $incorrect2Aptitude * 0.2; 
            $negative2Chemistry = $incorrect2Chemistry * 0.2; 
            $negative2English = $incorrect2English * 0.2; 
            $negative2Math = $incorrect2Math * 0.2; 
            $negative2Physics = $incorrect2Physics * 0.2; 

            $scoreAptitude =  $correct1Aptitude + 2 * $correct2Aptitude - $negative1Aptitude - $negative2Aptitude;
            $scoreChemistry =  $correct1Chemistry + 2 * $correct2Chemistry - $negative1Chemistry - $negative2Chemistry;
            $scoreEnglish =  $correct1English + 2 * $correct2English - $negative1English - $negative2English;
            $scoreMath =  $correct1Math + 2 * $correct2Math - $negative1Math - $negative2Math;
            $scorePhysics =  $correct1Physics + 2 * $correct2Physics - $negative1Physics - $negative2Physics;

            
            $attempted_question_separate = [
                'total1Aptitude' => $total1Aptitude,
                'total1Chemistry' => $total1Chemistry,
                'total1English' => $total1English,
                'total1Math' => $total1Math,
                'total1Physics' => $total1Physics,
                'total1Marks' => $total1Marks,

                'total2Aptitude' => $total2Aptitude,
                'total2Chemistry' => $total2Chemistry,
                'total2English' => $total2English,
                'total2Math' => $total2Math,
                'total2Physics' => $total2Physics,
                'total2Marks' => $total2Marks,

                'attempted1Aptitude' => $attempted1Aptitude,
                'attempted1Chemistry' => $attempted1Chemistry,
                'attempted1English' => $attempted1English,
                'attempted1Math' => $attempted1Math,
                'attempted1Physics' => $attempted1Physics,

                'attempted2Aptitude' => $attempted2Aptitude,
                'attempted2Chemistry' => $attempted2Chemistry,
                'attempted2English' => $attempted2English,
                'attempted2Math' => $attempted2Math,
                'attempted2Physics' => $attempted2Physics,

                'correct1Aptitude' => $correct1Aptitude,
                'correct1Chemistry' => $correct1Chemistry,
                'correct1English' => $correct1English,
                'correct1Math' => $correct1Math,
                'correct1Physics' => $correct1Physics,

                'correct2Aptitude' => $correct2Aptitude,
                'correct2Chemistry' => $correct2Chemistry,
                'correct2English' => $correct2English,
                'correct2Math' => $correct2Math,
                'correct2Physics' => $correct2Physics,

                'scoreAptitude' => $scoreAptitude,
                'scoreChemistry' => $scoreChemistry,
                'scoreEnglish' => $scoreEnglish,
                'scoreMath' => $scoreMath,
                'scorePhysics' => $scorePhysics,
            ];

	        return view('exam.result', compact('all_questions', 'correct1Mark', 'correct2Mark', 'attempted1Mark', 'attempted2Mark', 'attempted', 'score', 'attempted_question_answers', 'attempted_question_separate', 'marks', 'subjects'));

        } catch (Exception $e) {
        	logger()->error($exception->getMessage());
        	$error_message = 'Internal Server Error , Please try again later or report to PI Academey';

        	return view('exam.result', compact('error_message'));
        }        
    }

    private function totalQuestion($total_question_answers, $mark, $subject)
    {
        $marks =ExaminationQuestion::Marks;
        $subjects = ExaminationQuestion::Subjects;

        return $total_question_answers
                    ->where('marks', array_flip($marks)[$mark])
                    ->where('subject', array_flip($subjects)[$subject])
                    ->all();
    }

    private function attemptedMark(array $attempted_question_answers, $marks, $subject)
    {
        return collect($attempted_question_answers)
                    ->where('marks', $marks)
                    ->where('subject', $subject)
                    ->all();
    }

    private function correctAnswer(array $attempted_question_answers, $marks, $subject)
    {
        return collect($attempted_question_answers)
                        ->where('marks', $marks)
                        ->where('subject', $subject)
                        ->map(function($question) {
                            if($question['choosen_answer'] == $question['correct_answer']) {
                                return $question;
                            }
                        })->filter();
    }

    private function seoCheck($set_type)
    {
        SEOMeta::setTitle('Check the result - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' - Check the result after completing the exam. See the attempted short answer, long answer, attempted marks of each and score you have obtained. See the total questions, attempted questions with the choosen answer and score of each subject.');
        SEOMeta::setCanonical(route('exam.check', $set_type));
        SEOMeta::addKeyword(['exam', 'nepal', 'pulchowk', 'engineering', 'students', 'campus', 'bachelor', 'kathmandu', 'pokhara', 'secondhand', 'online', 'tu', 'pi-academy', 'sets', 'notice', 'before-exam']);
        
        OpenGraph::setTitle('Check the result - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' - Check the result after completing the exam. See the attempted short answer, long answer, attempted marks of each and score you have obtained. See the total questions, attempted questions with the choosen answer and score of each subject.');
        OpenGraph::setUrl(route('exam.check', $set_type));
    }
}
