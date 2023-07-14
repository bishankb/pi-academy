@extends('layouts.backend')

@section('title')
    Show Result Detail
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Overall Result
                    <small class="font-green sbold">Show</small>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Attempted 1 Marks:</strong> {{ $totalAttempted_question_separate['total1Attempted'] }}
            </li>
            <li class="list-group-item">
                <strong>Attempted 2 Marks:</strong> {{ $totalAttempted_question_separate['total2Attempted'] }}
            </li>
            <li class="list-group-item">
                <strong>Correct 1 Marks:</strong> {{ $totalAttempted_question_separate['total1Corrected'] }}
            </li>
            <li class="list-group-item">
                <strong>Correct 2 Marks:</strong> {{ $totalAttempted_question_separate['total2Corrected'] }}
            </li>
            <li class="list-group-item">
                <strong>Total Attempted:</strong> {{ $totalAttempted_question_separate['total1Attempted'] + $totalAttempted_question_separate['total2Attempted'] }}
            </li>
            <li class="list-group-item">
                <strong>Score:</strong> {{ $totalAttempted_question_separate['totalScore'] }}
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
                        <td>{{ $totalAttempted_question_separate['total1Aptitude'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted1Aptitude'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct1Aptitude'] }}</td>

                        <td>{{ $totalAttempted_question_separate['total2Aptitude'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted2Aptitude'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct2Aptitude'] }}</td>

                        <td>{{ $totalAttempted_question_separate['scoreAptitude'] }}</td>
                    </tr>
                    <tr>
                        <td>Chemistry</td>
                        <td>{{ $totalAttempted_question_separate['total1Chemistry'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted1Chemistry'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct1Chemistry'] }}</td>

                        <td>{{ $totalAttempted_question_separate['total2Chemistry'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted2Chemistry'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct2Chemistry'] }}</td>

                        <td>{{ $totalAttempted_question_separate['scoreChemistry'] }}</td>
                    </tr>
                    <tr>
                        <td>English</td>
                        <td>{{ $totalAttempted_question_separate['total1English'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted1English'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct1English'] }}</td>

                        <td>{{ $totalAttempted_question_separate['total2English'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted2English'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct2English'] }}</td>

                        <td>{{ $totalAttempted_question_separate['scoreEnglish'] }}</td>
                    </tr>
                    <tr>
                        <td>Math</td>
                        <td>{{ $totalAttempted_question_separate['total1Math'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted1Math'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct1Math'] }}</td>

                        <td>{{ $totalAttempted_question_separate['total2Math'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted2Math'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct2Math'] }}</td>

                        <td>{{ $totalAttempted_question_separate['scoreMath'] }}</td>
                    </tr>
                    <tr>
                        <td>Physics</td>
                        <td>{{ $totalAttempted_question_separate['total1Physics'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted1Physics'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct1Physics'] }}</td>

                        <td>{{ $totalAttempted_question_separate['total2Physics'] }}</td>
                        <td>{{ $totalAttempted_question_separate['attempted2Physics'] }}</td>
                        <td>{{ $totalAttempted_question_separate['correct2Physics'] }}</td>

                        <td>{{ $totalAttempted_question_separate['scorePhysics'] }}</td>
                    </tr>

                    <tr style="font-weight: bold;">
                        <td>Total</td>
                        <td>{{ $totalAttempted_question_separate['total1Marks'] }}</td>
                        <td>{{ $totalAttempted_question_separate['total1Attempted'] }}</td>
                        <td>{{ $totalAttempted_question_separate['total1Corrected'] }}</td>
                        <td>{{ $totalAttempted_question_separate['total2Marks'] }}</td>
                        <td>{{ $totalAttempted_question_separate['total2Attempted'] }}</td>
                        <td>{{ $totalAttempted_question_separate['total2Corrected'] }}</td>
                        <td>{{ $totalAttempted_question_separate['totalScore'] }}</td>
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

    <div class="portlet-footer">
        <div class="form-group">
            <a href="{{ route('clients.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>
        </div>
    </div>
@endsection

@section('backend-script')

    @include('backend.examination-result._student-show_js')
    
@endsection