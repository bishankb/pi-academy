<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QuestionSet;
use Auth;
use Carbon\Carbon;

class QuestionSetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_question_sets', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_question_sets', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_question_sets', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_question_sets', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question_sets = QuestionSet::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->sort(request('criteria'))
                      ->orderBy('order')
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));


        $total_question_set = QuestionSet::count();
               
        return view('backend.question-set.index', compact('question_sets', 'total_question_set'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.question-set.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name'        => 'required|string|max:255|unique:question_sets,name',
                'order'       => 'required|integer|unique:question_sets,order',
                'description' => 'nullable|min:1|max:65535',
            ]
        );

        try {
            $question_set = QuestionSet::create(
                [
                    'name'        => request('name'),
                    'slug'        => $this->setSlugAttribute(request('name')),
                    'order'       => request('order'),
                    'description' => request('description'),
                    'created_by'  => Auth::user()->id,
                    'updated_by'  => Auth::user()->id
                ]
            );
            flash('Question set added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the question set.')->error();
        }

        return redirect(route('question-sets.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question_set = QuestionSet::withTrashed()->find($id);

        return view('backend.question-set.show', compact('question_set'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question_set = QuestionSet::withTrashed()->find($id);

        return view('backend.question-set.edit', compact('question_set'));
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
        $question_set = QuestionSet::withTrashed()->find($id);

        $this->validate($request,
            [
                'name'        => 'required|string|max:255|unique:question_sets,name,'.$question_set->id,
                'order'       => 'required|integer|unique:question_sets,order,'.$question_set->id,
                'description' => 'nullable|min:1|max:65535'
            ]
        );

        try {
            if ($question_set->name != request('name')) {
                $question_set->update(['slug' => $this->setSlugAttribute(request('name'))]);
            }

            $question_set->update([
                'name'        => request('name'),
                'order'       => request('order'),
                'description' => request('description'),
                'updated_by'  => Auth::user()->id
            ]);
            flash('Question set updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the question set.')->error();
        }

        return redirect(route('question-sets.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question_set = QuestionSet::find($id);

        try {
            $question_set->delete();
            flash('Question set deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set.')->error();
        }

        return redirect(route('question-sets.index'));
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
        $question_set = QuestionSet::withTrashed()->find($id);

        try {
            $question_set->restore();
            flash('Question set restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the question set.')->error();
        }

        return redirect(route('question-sets.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $question_set = QuestionSet::withTrashed()->find($id);

        try {
            $question_set->forcedelete();
            flash('Question set deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the question set permanently.')->error();
        }

        return redirect(route('question-sets.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Creating the unique slug.
     *
     */
    private function setSlugAttribute($slug)
    {
        $slug = str_slug($slug);
        $slugs = QuestionSet::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
                    ->orderBy('id')
                    ->pluck('slug');
        if (count($slugs) == 0) {
            return $slug;
        } elseif (! $slugs->isEmpty()) {
            $pieces = explode('-', $slugs);
            $number = (int) end($pieces);
            return $slug .= '-' . ($number + 1);
        }
    }
}
