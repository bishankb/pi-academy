<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\QuestionSet;

class ComposerViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         view()->composer(
            ['backend.partials.sidebar'],
            function ($view) {
                $question_sets = QuestionSet::orderBy('order')->get();

                $view->with('question_sets', $question_sets);
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
