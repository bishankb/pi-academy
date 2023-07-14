@extends('layouts.backend')

@section('title')
    Show Result Detail
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> {{ $client->username }}
                    <small class="font-green sbold">Result Detail</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Set:</strong> {{ $examination_result->set->name }}
            </li>
            <li class="list-group-item">
                <strong>Attempted 1 Marks:</strong> {{ $examination_result->attempted_1_mark }}
            </li>
            <li class="list-group-item">
                <strong>Attempted 2 Marks:</strong> {{ $examination_result->attempted_2_mark }}
            </li>
            <li class="list-group-item">
                <strong>Correct 1 Marks:</strong> {{ $examination_result->correct_1_mark }}
            </li>
            <li class="list-group-item">
                <strong>Correct 2 Marks:</strong> {{ $examination_result->correct_2_mark }}
            </li>
            <li class="list-group-item">
                <strong>Total Attempted:</strong> {{ $examination_result->attempted }}
            </li>
            <li class="list-group-item">
                <strong>Score:</strong> {{ $examination_result->score }}
            </li>
        </ul>
    </div>

    <div class="panel panel-default" >
        <div class="panel-heading"><strong>Table View:</strong></div>
        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Total</th>
                        <th colspan="2" style="text-align: center;">One Mark</th>
                        <th>Total</th>
                        <th colspan="2" style="text-align: center;">Two Marks</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Attempted</td>
                        <td>Correct</td>
                        <td></td>
                        <td>Attempted</td>
                        <td>Correct</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Aptitude</td>
                        <td>{{ $attempted_question_separate['total1Aptitude'] }}</td>
                        <td>{{ $attempted_question_separate['attempted1Aptitude'] }}</td>
                        <td>{{ $attempted_question_separate['correct1Aptitude'] }}</td>

                        <td>{{ $attempted_question_separate['total2Aptitude'] }}</td>
                        <td>{{ $attempted_question_separate['attempted2Aptitude'] }}</td>
                        <td>{{ $attempted_question_separate['correct2Aptitude'] }}</td>

                        <td>{{ $attempted_question_separate['scoreAptitude'] }}</td>
                    </tr>
                    <tr>
                        <td>Chemistry</td>
                        <td>{{ $attempted_question_separate['total1Chemistry'] }}</td>
                        <td>{{ $attempted_question_separate['attempted1Chemistry'] }}</td>
                        <td>{{ $attempted_question_separate['correct1Chemistry'] }}</td>

                        <td>{{ $attempted_question_separate['total2Chemistry'] }}</td>
                        <td>{{ $attempted_question_separate['attempted2Chemistry'] }}</td>
                        <td>{{ $attempted_question_separate['correct2Chemistry'] }}</td>

                        <td>{{ $attempted_question_separate['scoreChemistry'] }}</td>
                    </tr>
                    <tr>
                        <td>English</td>
                        <td>{{ $attempted_question_separate['total1English'] }}</td>
                        <td>{{ $attempted_question_separate['attempted1English'] }}</td>
                        <td>{{ $attempted_question_separate['correct1English'] }}</td>

                        <td>{{ $attempted_question_separate['total2English'] }}</td>
                        <td>{{ $attempted_question_separate['attempted2English'] }}</td>
                        <td>{{ $attempted_question_separate['correct2English'] }}</td>

                        <td>{{ $attempted_question_separate['scoreEnglish'] }}</td>
                    </tr>
                    <tr>
                        <td>Math</td>
                        <td>{{ $attempted_question_separate['total1Math'] }}</td>
                        <td>{{ $attempted_question_separate['attempted1Math'] }}</td>
                        <td>{{ $attempted_question_separate['correct1Math'] }}</td>

                        <td>{{ $attempted_question_separate['total2Math'] }}</td>
                        <td>{{ $attempted_question_separate['attempted2Math'] }}</td>
                        <td>{{ $attempted_question_separate['correct2Math'] }}</td>

                        <td>{{ $attempted_question_separate['scoreMath'] }}</td>
                    </tr>
                    <tr>
                        <td>Physics</td>
                        <td>{{ $attempted_question_separate['total1Physics'] }}</td>
                        <td>{{ $attempted_question_separate['attempted1Physics'] }}</td>
                        <td>{{ $attempted_question_separate['correct1Physics'] }}</td>

                        <td>{{ $attempted_question_separate['total2Physics'] }}</td>
                        <td>{{ $attempted_question_separate['attempted2Physics'] }}</td>
                        <td>{{ $attempted_question_separate['correct2Physics'] }}</td>

                        <td>{{ $attempted_question_separate['scorePhysics'] }}</td>
                    </tr>

                    <tr style="font-weight: bold;">
                        <td>Total</td>
                        <td>{{ $attempted_question_separate['total1Marks'] }}</td>
                        <td>{{ $examination_result->attempted_1_mark }}</td>
                        <td>{{ $examination_result->correct_1_mark }}</td>
                        <td>{{ $attempted_question_separate['total2Marks'] }}</td>
                        <td>{{ $examination_result->attempted_2_mark }}</td>
                        <td>{{ $examination_result->correct_2_mark }}</td>
                        <td>{{ $examination_result->score }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Graphical View: One Mark</strong></div>
                <div id="oneMarkChart"></div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Two Mark:</strong></div>
                <div id="twoMarkChart"></div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Attempted Questions ({{ $examination_result->attempted }} out of {{ count($examination_result->set->questions) }}) :</strong> </div>
        <div class="panel-body">
            @foreach($attempted_question_answers as $key => $attempted_question_answer)
                @if ($key <= 3)
                    <div class="result-question-answer">
                        <div class="result-question">Q{{ $loop->iteration }}) {!! $attempted_question_answer['question'] !!}</div>
                        <div class="result-option">Option:-
                            <ol type="a">
                                <li>{!! $attempted_question_answer['option1'] !!}</li>
                                <li>{!! $attempted_question_answer['option2'] !!}</li>
                                <li>{!! $attempted_question_answer['option3'] !!}</li>
                                <li>{!! $attempted_question_answer['option4'] !!}</li>
                            </ol>
                        </div>
                        <div class="result-answer">Ans:- 
                            @if($attempted_question_answer['correct_answer'] == 1)
                                {!! $attempted_question_answer['option1'] !!}
                            @elseif($attempted_question_answer['correct_answer'] == 2)
                                {!! $attempted_question_answer['option2'] !!}
                            @elseif($attempted_question_answer['correct_answer'] == 3)
                                {!! $attempted_question_answer['option3'] !!}
                            @else
                                {!! $attempted_question_answer['option4'] !!}
                            @endif
                            @if($attempted_question_answer['choosen_answer'] == $attempted_question_answer['correct_answer'])
                                <span class="label label-success pull-right">Correct</span>
                            @else
                                <span class="label label-danger pull-right">
                                    @if($attempted_question_answer['choosen_answer'] == '1')
                                        {!! $attempted_question_answer['option1'] !!}
                                    @elseif($attempted_question_answer['choosen_answer'] == '2')
                                        {!! $attempted_question_answer['option2'] !!}
                                    @elseif($attempted_question_answer['choosen_answer'] == '3')
                                        {!! $attempted_question_answer['option3'] !!}
                                    @else
                                        {!! $attempted_question_answer['option4'] !!}
                                    @endif
                                </span>
                            @endif
                        </div>
                        @isset($attempted_question_answer['solution'])
                            <div class="result-solution">Solution:-
                                {!! $attempted_question_answer['solution'] !!}
                            </div>
                        @endisset
                    </div>
                @endif
            @endforeach
            <div class="collapse" id="attemptedQuestions">
                @foreach($attempted_question_answers as $key => $attempted_question_answer)
                    @if ($key >= 4)
                        <div class="result-question-answer">
                            @if(isset($attempted_question_answer['paragraph']) && $attempted_question_answer['subject'] == 'English' && $attempted_question_answer['marks'] == '2 Marks')
                                @if(collect($attempted_question_answers)->where('marks', '2 Marks')->where('subject', 'English')->first()['id'] == $attempted_question_answer['id'])
                                    <div class="result-paragraph">Paragraph:-<br>
                                        {!! $attempted_question_answer['paragraph'] !!}
                                    </div>
                                @endif
                            @endif
                            <div class="result-question">Q{{ $loop->iteration }}) {!! $attempted_question_answer['question'] !!}</div>
                            <div class="result-option">Option:-
                                <ol type="a">
                                    <li>{!! $attempted_question_answer['option1'] !!}</li>
                                    <li>{!! $attempted_question_answer['option2'] !!}</li>
                                    <li>{!! $attempted_question_answer['option3'] !!}</li>
                                    <li>{!! $attempted_question_answer['option4'] !!}</li>
                                </ol>
                            </div>
                            <div class="result-answer">Ans:-
                                @if($attempted_question_answer['correct_answer'] == 1)
                                    {!! $attempted_question_answer['option1'] !!}
                                @elseif($attempted_question_answer['correct_answer'] == 2)
                                    {!! $attempted_question_answer['option2'] !!}
                                @elseif($attempted_question_answer['correct_answer'] == 3)
                                    {!! $attempted_question_answer['option3'] !!}
                                @else
                                    {!! $attempted_question_answer['option4'] !!}
                                @endif
                                @if($attempted_question_answer['choosen_answer'] == $attempted_question_answer['correct_answer'])
                                    <span class="label label-success pull-right">Correct</span>
                                @else
                                    <span class="label label-danger pull-right">
                                        @if($attempted_question_answer['choosen_answer'] == '1')
                                            {!! $attempted_question_answer['option1'] !!}
                                        @elseif($attempted_question_answer['choosen_answer'] == '2')
                                            {!! $attempted_question_answer['option2'] !!}
                                        @elseif($attempted_question_answer['choosen_answer'] == '3')
                                            {!! $attempted_question_answer['option3'] !!}
                                        @else
                                            {!! $attempted_question_answer['option4'] !!}
                                        @endif
                                    </span>
                                @endif
                            </div>
                            @isset($attempted_question_answer['solution'])
                                <div class="result-solution">Solution:-
                                    {!! $attempted_question_answer['solution'] !!}
                                </div>
                            @endisset
                        </div>
                    @endif
                @endforeach
            </div>
            @if(count($attempted_question_answers) > 3)
                <button class="btn btn-info see-more" data-toggle="collapse" data-target="#attemptedQuestions">See More &raquo;</button>
            @endif
        </div>
    </div>

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('clients.resultIndex', $client->id) }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

@section('backend-script')

    @include('backend.examination-result.examination-record._show_js')
    
@endsection