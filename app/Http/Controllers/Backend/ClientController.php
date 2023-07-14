<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OnlineExaminationCredential;
use App\ExaminationResult;
use App\ExaminationQuestion;
use App\StudentRegistration;
use App\ScholarshipTest;
use App\QuestionSet;
use Auth;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_clients', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_clients', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_clients', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_clients', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = OnlineExaminationCredential::where('is_client', 1)
                      ->search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->sort(request('criteria'))
                      ->latest()
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $total_client = OnlineExaminationCredential::where('is_client', 1)->count();

        return view('backend.client.index', compact('clients', 'education_levels', 'interested_courses', 'total_client'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $examination_results = ExaminationResult::where('student_id', $id)->get();

        $totalAattempted_question_separate = [];

        foreach ($examination_results as $examination_result) {
            $attemptedQuestionOrder = implode(',',$examination_result->attempted_questions);

            if($attemptedQuestionOrder) {
                $attemptedQuestions =  ExaminationQuestion::orderBy('marks')
                                                            ->whereIn('id', $examination_result->attempted_questions)
                                                            ->orderByRaw("FIELD(id , $attemptedQuestionOrder) ASC")
                                                            ->get();
            } else {
                 $attemptedQuestions = [];
            }

            $attempted_question_answers = [];

            foreach ($attemptedQuestions as $key => $attemptedQuestion) {
                array_push($attempted_question_answers, [
                    'id' => $attemptedQuestion->id,
                    'question' => $attemptedQuestion->question,
                    'choosen_answer' => (int)$examination_result->choosen_answers[$key],
                    'option1' => $attemptedQuestion->option1,
                    'option2' => $attemptedQuestion->option2,
                    'option3' => $attemptedQuestion->option3,
                    'option4' => $attemptedQuestion->option4,
                    'solution' => $attemptedQuestion->solution,
                    'correct_answer' => $attemptedQuestion->correct_answer,
                    'subject' => ExaminationQuestion::Subjects[$attemptedQuestion->subject],
                    'marks' => ExaminationQuestion::Marks[$attemptedQuestion->marks]
                ]);
            }

            $attempted1Aptitude = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'Aptitude'));
            $attempted1Chemistry = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'Chemistry'));
            $attempted1English = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'English'));
            $attempted1Math = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'Math'));
            $attempted1Physics = count($this->attemptedMark($attempted_question_answers, '1 Mark', 'Physics'));
            $total1Attempted = $attempted1Aptitude + $attempted1Chemistry + $attempted1English + $attempted1Math + $attempted1Physics;

            $attempted2Aptitude = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'Aptitude'));
            $attempted2Chemistry = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'Chemistry'));
            $attempted2English = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'English'));
            $attempted2Math = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'Math'));
            $attempted2Physics = count($this->attemptedMark($attempted_question_answers, '2 Marks', 'Physics'));
            $total2Attempted = $attempted2Aptitude + $attempted2Chemistry + $attempted2English + $attempted2Math + $attempted2Physics;

            $correct1Aptitude = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'Aptitude'));
            $correct1Chemistry = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'Chemistry'));
            $correct1English = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'English'));
            $correct1Math = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'Math'));
            $correct1Physics = count($this->correctAnswer($attempted_question_answers, '1 Mark', 'Physics'));
            $total1Corrected = $correct1Aptitude + $correct1Chemistry + $correct1English + $correct1Math + $correct1Physics;

            $correct2Aptitude = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'Aptitude'));
            $correct2Chemistry = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'Chemistry'));
            $correct2English = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'English'));
            $correct2Math = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'Math'));
            $correct2Physics = count($this->correctAnswer($attempted_question_answers, '2 Marks', 'Physics'));
            $total2Corrected = $correct2Aptitude + $correct2Chemistry + $correct2English + $correct2Math + $correct2Physics;

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
            $totalScore = $scoreAptitude + $scoreChemistry + $scoreEnglish + $scoreMath + $scorePhysics;

            $attempted_question_separate = [
                'attempted1Aptitude' => $attempted1Aptitude,
                'attempted1Chemistry' => $attempted1Chemistry,
                'attempted1English' => $attempted1English,
                'attempted1Math' => $attempted1Math,
                'attempted1Physics' => $attempted1Physics,
                'total1Attempted' => $total1Attempted,

                'attempted2Aptitude' => $attempted2Aptitude,
                'attempted2Chemistry' => $attempted2Chemistry,
                'attempted2English' => $attempted2English,
                'attempted2Math' => $attempted2Math,
                'attempted2Physics' => $attempted2Physics,
                'total2Attempted' => $total2Attempted,

                'correct1Aptitude' => $correct1Aptitude,
                'correct1Chemistry' => $correct1Chemistry,
                'correct1English' => $correct1English,
                'correct1Math' => $correct1Math,
                'correct1Physics' => $correct1Physics,
                'total1Corrected' => $total1Corrected,

                'correct2Aptitude' => $correct2Aptitude,
                'correct2Chemistry' => $correct2Chemistry,
                'correct2English' => $correct2English,
                'correct2Math' => $correct2Math,
                'correct2Physics' => $correct2Physics,
                'total2Corrected' => $total2Corrected,

                'scoreAptitude' => $scoreAptitude,
                'scoreChemistry' => $scoreChemistry,
                'scoreEnglish' => $scoreEnglish,
                'scoreMath' => $scoreMath,
                'scorePhysics' => $scorePhysics,
                'totalScore' => $totalScore
            ];

            array_push($totalAattempted_question_separate, $attempted_question_separate);
        }

        $all_questions = ExaminationResult::where('student_id', $id)
                                                ->with(['set' => function($set){
                                                    $set->with(['questions']);
                                                }])
                                                ->get()
                                                ->pluck('set.questions')
                                                ->flatten(1);

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

         $totalAttempted_question_separate = [
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

            'attempted1Aptitude' => array_sum(array_column($totalAattempted_question_separate, 'attempted1Aptitude')),
            'attempted1Chemistry' => array_sum(array_column($totalAattempted_question_separate, 'attempted1Chemistry')),
            'attempted1English' => array_sum(array_column($totalAattempted_question_separate, 'attempted1English')),
            'attempted1Math' => array_sum(array_column($totalAattempted_question_separate, 'attempted1Math')),
            'attempted1Physics' => array_sum(array_column($totalAattempted_question_separate, 'attempted1Physics')),
            'total1Attempted' => array_sum(array_column($totalAattempted_question_separate, 'total1Attempted')),

            'attempted2Aptitude' => array_sum(array_column($totalAattempted_question_separate, 'attempted2Aptitude')),
            'attempted2Chemistry' => array_sum(array_column($totalAattempted_question_separate, 'attempted2Chemistry')),
            'attempted2English' => array_sum(array_column($totalAattempted_question_separate, 'attempted2English')),
            'attempted2Math' => array_sum(array_column($totalAattempted_question_separate, 'attempted2Math')),
            'attempted2Physics' => array_sum(array_column($totalAattempted_question_separate, 'attempted2Physics')),
            'total2Attempted' => array_sum(array_column($totalAattempted_question_separate, 'total2Attempted')),

            'correct1Aptitude' => array_sum(array_column($totalAattempted_question_separate, 'correct1Aptitude')),
            'correct1Chemistry' => array_sum(array_column($totalAattempted_question_separate, 'correct1Chemistry')),
            'correct1English' => array_sum(array_column($totalAattempted_question_separate, 'correct1English')),
            'correct1Math' => array_sum(array_column($totalAattempted_question_separate, 'correct1Math')),
            'correct1Physics' => array_sum(array_column($totalAattempted_question_separate, 'correct1Physics')),
            'total1Corrected' => array_sum(array_column($totalAattempted_question_separate, 'total1Corrected')),

            'correct2Aptitude' => array_sum(array_column($totalAattempted_question_separate, 'correct2Aptitude')),
            'correct2Chemistry' => array_sum(array_column($totalAattempted_question_separate, 'correct2Chemistry')),
            'correct2English' => array_sum(array_column($totalAattempted_question_separate, 'correct2English')),
            'correct2Math' => array_sum(array_column($totalAattempted_question_separate, 'correct2Math')),
            'correct2Physics' => array_sum(array_column($totalAattempted_question_separate, 'correct2Physics')),
            'total2Corrected' => array_sum(array_column($totalAattempted_question_separate, 'total2Corrected')),

            'scoreAptitude' => array_sum(array_column($totalAattempted_question_separate, 'scoreAptitude')),
            'scoreChemistry' => array_sum(array_column($totalAattempted_question_separate, 'scoreChemistry')),
            'scoreEnglish' => array_sum(array_column($totalAattempted_question_separate, 'scoreEnglish')),
            'scoreMath' => array_sum(array_column($totalAattempted_question_separate, 'scoreMath')),
            'scorePhysics' => array_sum(array_column($totalAattempted_question_separate, 'scorePhysics')),
            'totalScore' => array_sum(array_column($totalAattempted_question_separate, 'totalScore')),
        ];

        return view('backend.client.show', compact('totalAttempted_question_separate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = OnlineExaminationCredential::withTrashed()->where('is_client', 1)->find($id);

        return view('backend.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $examination_credential = OnlineExaminationCredential::withTrashed()->where('is_client', 1)->find($id);

        $this->validate($request,
            [
                'email'               => 'required|string|email|max:255|unique:online_examination_credentials,email,'.$id.',id,deleted_at,NULL',
                'username'            => 'required|string|min:1|max:255'
            ]
        );

        if(isset($request->password)) {
            $this->validate($request,
                [
                    'password' => 'required|string|min:6||max:255'
                ]
            );
        }

        try {
            $examination_credential->update([
                'email'    => request('email'),
                'username' => request('username'),
                'verified' => request('verified') ? 1 : 0,
            ]);

            if(isset($request->password)) {
                $examination_credential->update([
                    'password' => bcrypt(request('password')),
                ]);
            }

            flash('Client detail updated successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the client detail.')->error();
        }

        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = OnlineExaminationCredential::where('is_client', 1)->find($id);

        try {
            $client->delete();
            flash('Client deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the client.')->error();
        }

        return redirect(route('clients.index'));
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $client = OnlineExaminationCredential::withTrashed()->where('is_client', 1)->find($id);

       try {
            if(count($clients) > 1) {
                flash('Email with '. $client->email . 'already exists. Please rename the email before restoring.')->error();
                return redirect(route('clients.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
            }

            $client->restore();
            flash('Client restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the client .')->error();
        }

        return redirect(route('clients.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Force remove the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($id)
    {
        $client = OnlineExaminationCredential::withTrashed()->where('is_client', 1)->find($id);

        try {
            $client->forcedelete();
            flash('Client deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the client permanently.')->error();
        }

        return redirect(route('clients.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $examination_credential = OnlineExaminationCredential::withTrashed()->where('is_client', 1)->find($id);

        try {
            $examination_credential->update(
                [
                    'verified'=> request('status')
                ]
            );
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
        }
    }

    public function resultIndex($client_id)
    {
        $examination_results = ExaminationResult::where('student_id', $client_id)
                                                  ->setFilter(request('set'))
                                                  ->sort(request('criteria'))
                                                  ->latest()
                                                  ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $client = OnlineExaminationCredential::where('is_client', 1)->find($client_id);
        $question_sets = QuestionSet::whereHas('examinationRecords')->get();
        $total_examination_result = ExaminationResult::where('student_id', $client_id)->count();
        
        return view('backend.client.examination-record.index', compact('examination_results', 'client', 'question_sets', 'total_examination_result'));
    }

    public function resultShow($client_id, $id)
    {
        $client = OnlineExaminationCredential::where('is_client', 1)->find($client_id);

        $examination_result = ExaminationResult::where('student_id', $client_id)->find($id);

        $attemptedQuestionOrder = implode(',',$examination_result->attempted_questions);

        if($attemptedQuestionOrder) {
            $attemptedQuestions =  ExaminationQuestion::where('question_set_id', $examination_result->set->id)
                                                        ->orderBy('marks')
                                                        ->whereIn('id', $examination_result->attempted_questions)
                                                        ->orderByRaw("FIELD(id , $attemptedQuestionOrder) ASC")
                                                        ->get();
        } else {
             $attemptedQuestions = [];
        }


        $attempted_question_answers = [];

        if(isset($examination_result->set->paragraph)) {
            $paragraph = $examination_result->set->paragraph->paragraph;
        } else {
            $paragraph = null;
        }

        foreach ($attemptedQuestions as $key => $attemptedQuestion) {
            array_push($attempted_question_answers, [
                'id' => $attemptedQuestion->id,
                'question' => $attemptedQuestion->question,
                'choosen_answer' => (int)$examination_result->choosen_answers[$key],
                'option1' => $attemptedQuestion->option1,
                'option2' => $attemptedQuestion->option2,
                'option3' => $attemptedQuestion->option3,
                'option4' => $attemptedQuestion->option4,
                'correct_answer' => $attemptedQuestion->correct_answer,
                'solution' => $attemptedQuestion->solution,
                'paragraph' => $paragraph,
                'subject' => ExaminationQuestion::Subjects[$attemptedQuestion->subject],
                'marks' => ExaminationQuestion::Marks[$attemptedQuestion->marks]
            ]);
        }

        $all_questions = ExaminationQuestion::where('question_set_id', $examination_result->set->id)
                                              ->orderBy('marks')
                                              ->get();

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

        return view('backend.client.examination-record.show', compact('examination_result', 'client', 'attempted_question_answers', 'attempted_question_separate'));
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
}
