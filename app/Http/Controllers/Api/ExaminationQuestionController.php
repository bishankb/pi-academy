<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\ExaminationQuestion;
use App\ExaminationResult;
use App\QuestionSet;
use App\Http\Resources\ExaminationQuestionResource;

class ExaminationQuestionController extends Controller
{
    public function getQuestions($id)
    {
        try {
            $set = QuestionSet::find($id);
            $marks = ExaminationQuestion::Marks;
            $subjects = ExaminationQuestion::Subjects;

            $one_mark_questions = ExaminationQuestion::where('question_set_id', $set->id)
                                                        ->where('marks', array_flip($marks)['1 Mark'])
                                                        ->select('id', 'subject', 'marks', 'question', 'option1', 'option2', 'option3', 'option4', 'correct_answer', 'solution')
                                                        ->get()
                                                        ->groupBy('subject')
                                                        ->shuffle()
                                                        ->flatten(1);
                                                       
            $two_mark_questions = ExaminationQuestion::where('question_set_id', $set->id)
                                                        ->where('marks', array_flip($marks)['2 Marks'])
                                                        ->select('id', 'subject', 'marks', 'question', 'option1', 'option2', 'option3', 'option4', 'correct_answer', 'solution')
                                                        ->get()
                                                        ->groupBy('subject')
                                                        ->shuffle()
                                                        ->flatten(1);

            return response()->json([
                'status' => 'success',
                'one_mark_questions' => $one_mark_questions,
                'two_mark_questions' => $two_mark_questions,
                'english_paragraph' => $set->paragraph->paragraph
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error!! Please try again',
            ], 500);
        }
        
    }

    public function takeExam(Request $request)
    {
        try {
            $question_result = ExaminationResult::create(
                [
                    'student_id'          => request('student_id'),
                    'question_set_id'     => request('question_set_id'),
                    'attempted_1_mark'    => request('attempted_1_mark'),
                    'attempted_2_mark'    => request('attempted_2_mark'),
                    'correct_1_mark'      => request('correct_1_mark'),
                    'correct_2_mark'      => request('correct_2_mark'),
                    'attempted'           => request('attempted'),
                    'score'               => request('score'),
                    'attempted_questions' => request('attempted_questions'),
                    'choosen_answers'     => request('choosen_answers')
                ]
            );
            return response()->json([
                'status'  => 'success',
                'message' => 'You have successfully completed the exam'
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error!! Please try again',
            ], 500);
        }
    }
}