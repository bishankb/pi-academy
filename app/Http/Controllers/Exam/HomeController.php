<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QuestionSet;
use SEOMeta;
use OpenGraph;

class HomeController extends Controller
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

    public function index()
    {
        $this->seoIndex();

        $question_sets = QuestionSet::whereHas('questions')->orderBy('order')->get();

        $colors = [
            '#ac143b', '#14ac4a', '#aca714', '#14ac89', '#2252bd', '#2284bd', '#c73393', '#9844bb', '#ccaa4a', '#3fbdbd', '#a96490', '#e03964'
        ];

        $remaining_colors =  $question_sets->count() - count($colors);
        
        for ( $i=0; $i < $remaining_colors; $i++) { 
            array_push($colors, $colors[$i]);
        }

        return view('exam.home', compact('question_sets', 'colors'));
    }

    public function beforeExam($set_type)
    {
        $this->seoBeforeExam($set_type);

        $set = QuestionSet::where('slug', $set_type)->whereHas('questions')->first();

        if(empty($set)) {
            abort(404);
        }

        return view('exam.before-exam', compact('set'));
    }

    private function seoIndex()
    {
        SEOMeta::setTitle('Online Examination For Engineering Students - '.env('APP_NAME'));
        SEOMeta::setDescription( env('APP_NAME').' - Prepare for the entrance examination through us. There are different questions available in our application. Practise more and get entry in the campus.');
        SEOMeta::setCanonical(route('exam.home'));
        SEOMeta::addKeyword(['exam', 'nepal', 'pulchowk', 'engineering', 'students', 'campus', 'bachelor', 'kathmandu', 'pokhara', 'secondhand', 'online', 'tu', 'pi-academy', 'sets']);
        
        OpenGraph::setTitle('Online Examination For Engineering Students - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' - Prepare for the entrance examination through us. There are different questions available in our application. Practise more and get entry in the campus.');
        OpenGraph::setUrl(route('exam.home'));
    }

    private function seoBeforeExam($set_type)
    {
        SEOMeta::setTitle('Notice Before Taking Exam - '.env('APP_NAME'));
        SEOMeta::setDescription( env('APP_NAME').' - You have to check radio button on correct option.If the selected option is wrong 10% negative marking will be applied.Click on next button to navigate to the next page.Click on previous button to navigate to the previous page.You can change your option during the examination period.Information along with time remaning, total attempted and total questions will be displayed at the top of your page.');
        SEOMeta::setCanonical(route('exam.before-exam', $set_type));
        SEOMeta::addKeyword(['exam', 'nepal', 'pulchowk', 'engineering', 'students', 'campus', 'bachelor', 'kathmandu', 'pokhara', 'secondhand', 'online', 'tu', 'pi-academy', 'sets', 'notice', 'before-exam']);
        
        OpenGraph::setTitle('Notice Before Taking Exam - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' - You have to check radio button on correct option.If the selected option is wrong 10% negative marking will be applied.Click on next button to navigate to the next page.Click on previous button to navigate to the previous page.You can change your option during the examination period.Information along with time remaning, total attempted and total questions will be displayed at the top of your page.');
        OpenGraph::setUrl(route('exam.before-exam', $set_type));
    }
}
