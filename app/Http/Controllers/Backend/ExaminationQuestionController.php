<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ExaminationQuestion;
use App\QuestionSet;
use App\Paragraph;
use Auth;
use DB;
use Carbon\Carbon;

class ExaminationQuestionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_examination_questions', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_examination_questions', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_examination_questions', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_examination_questions', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($set_type)
    {
        $set = QuestionSet::where('slug', $set_type)->first();

        $examination_questions = ExaminationQuestion::where('question_set_id', $set->id)
                      ->search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->subjectFilter(request('subject'))
                      ->marksFilter(request('marks'))
                      ->latest()
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $subjects = ExaminationQuestion::Subjects;
        $marks = ExaminationQuestion::Marks;
        $total_examination_question = ExaminationQuestion::where('question_set_id', $set->id)->count();

        return view('backend.examination-question.index', compact('examination_questions', 'set', 'subjects', 'marks', 'total_examination_question'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($set_type)
    {
        $set = QuestionSet::where('slug', $set_type)->first();
        $subjects = ExaminationQuestion::Subjects;
        $marks = ExaminationQuestion::Marks;
        $options = ExaminationQuestion::Options;
        
        if(isset($set->paragraph)) {
            $paragraph = $set->paragraph->paragraph;
        } else {
            $paragraph = null;
        }

        return view('backend.examination-question.create', compact('set', 'subjects', 'marks', 'options', 'paragraph'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $set_type)
    {       
        $set = QuestionSet::where('slug', $set_type)->first();

        $subjects = ExaminationQuestion::Subjects;
        $marks = ExaminationQuestion::Marks;

        $this->validate($request,
            [
                'subject'           => 'required|numeric',
                'marks'             => 'required|numeric',
                'question'          => 'required|string|min:1',
                'option1'           => 'required|string|min:1',
                'option2'           => 'required|string|min:1',
                'option3'           => 'required|string|min:1',
                'option4'           => 'required|string|min:1',
                'correct_answer'    => 'required|numeric',
                'solution'          => 'nullable|string|min:2',
                'paragraph'         => 'nullable|string|min:2',
            ]
        );

        DB::beginTransaction();
        try {
            $examination_question = ExaminationQuestion::create(
                [
                    'question_set_id' => $set->id,
                    'subject'         => request('subject'),
                    'marks'           => request('marks'),
                    'question'        => request('question'),
                    'option1'         => request('option1'),
                    'option2'         => request('option2'),
                    'option3'         => request('option3'),
                    'option4'         => request('option4'),
                    'correct_answer'  => request('correct_answer'),
                    'solution'        => request('solution'),
                    'created_by'      => Auth::user()->id,
                    'updated_by'      => Auth::user()->id,
                ]
            );

            if($request->subject == array_flip($subjects)['English'] && $request->marks == array_flip($marks)['2 Marks']) {
                if (!$set->paragraph) {
                    Paragraph::create([
                        'paragraph'       => request('paragraph'),
                        'question_set_id' => $set->id
                    ]);
                } else {
                    $set->paragraph->update(
                        [
                            'paragraph' => request('paragraph')
                        ]
                    );
                }
            }

            flash('Question added successfully.')->success();

            DB::commit();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            DB::rollback();
            flash('There was some intenal error while adding the question.')->error();
        }

        return redirect(route('examination-questions.index', $set_type));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($set_type, $id)
    {
        $set = QuestionSet::where('slug', $set_type)->first();
        $examination_question = ExaminationQuestion::withTrashed()->where('question_set_id', $set->id)->find($id);

        $subjects = ExaminationQuestion::Subjects;
        $marks = ExaminationQuestion::Marks;
        $options = ExaminationQuestion::Options;

        return view('backend.examination-question.show', compact('set', 'examination_question', 'subjects', 'marks', 'options'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($set_type, $id)
    {
        $set = QuestionSet::where('slug', $set_type)->first();
        $examination_question = ExaminationQuestion::withTrashed()->where('question_set_id', $set->id)->find($id);

        $subjects = ExaminationQuestion::Subjects;
        $options = ExaminationQuestion::Options;
        $marks = ExaminationQuestion::Marks;

        if(isset($set->paragraph)) {
            $paragraph = $set->paragraph->paragraph;
        } else {
            $paragraph = null;
        }

        return view('backend.examination-question.edit', compact('set', 'examination_question',  'subjects', 'marks', 'options', 'paragraph'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($set_type, Request $request, $id)
    {
        $set = QuestionSet::where('slug', $set_type)->first();
        $examination_question = ExaminationQuestion::withTrashed()->where('question_set_id', $set->id)->find($id);

        $subjects = ExaminationQuestion::Subjects;
        $marks = ExaminationQuestion::Marks;

        $this->validate($request,
            [
                'subject'           => 'required|numeric',
                'marks'             => 'required|numeric',
                'question'          => 'required|string|min:1',
                'option1'           => 'required|string|min:1',
                'option2'           => 'required|string|min:1',
                'option3'           => 'required|string|min:1',
                'option4'           => 'required|string|min:1',
                'correct_answer'    => 'required|numeric',
                'solution'          => 'nullable|string|min:2',
                'paragraph'         => 'nullable|string|min:2'
            ]
        );

        DB::beginTransaction();
        try {
            $examination_question->update([
                'subject'        => request('subject'),
                'marks'          => request('marks'),
                'question'       => request('question'),
                'option1'        => request('option1'),
                'option2'        => request('option2'),
                'option3'        => request('option3'),
                'option4'        => request('option4'),
                'correct_answer' => request('correct_answer'),
                'solution'       => request('solution'),
                'created_by'     => Auth::user()->id,
                'updated_by'     => Auth::user()->id,
                'updated_by'     => Auth::user()->id,
            ]);

            if($request->subject == array_flip($subjects)['English'] && $request->marks == array_flip($marks)['2 Marks']) {
                if (!$set->paragraph) {
                    Paragraph::create([
                        'paragraph'       => request('paragraph'),
                        'question_set_id' => $set->id
                    ]);
                } else {
                    $set->paragraph->update(
                        [
                            'paragraph' => request('paragraph')
                        ]
                    );
                }
            }

            flash('Question updated successfully.')->info();

            DB::commit();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            DB::rollback();
            flash('There was some intenal error while updating the question.')->error();
        }

        return redirect(route('examination-questions.index', $set_type));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($set_type, $id)
    {
        $set = QuestionSet::where('slug', $set_type)->first();
        $examination_question = ExaminationQuestion::where('question_set_id', $set->id)->find($id);

        try {
            $examination_question->delete();
            flash('Question deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question.')->error();
        }

        return redirect(route('examination-questions.index', $set_type));
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($set_type, $id)
    {
        $set = QuestionSet::where('slug', $set_type)->first();
        $examination_question = ExaminationQuestion::withTrashed()->where('question_set_id', $set->id)->find($id);

        try {
            $examination_question->restore();
            flash('Question restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the question.')->error();
        }

        return redirect(route('examination-questions.index', ['question_set_id' => $set_type, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Force remove the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($set_type, $id)
    {
        $set = QuestionSet::where('slug', $set_type)->first();
        $examination_question = ExaminationQuestion::withTrashed()->where('question_set_id', $set->id)->find($id);

        try {
            $examination_question->forcedelete();
            flash('Question deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question permanently.')->error();
        }

        return redirect(route('examination-questions.index', ['question_set_id' => $set_type, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }
}
