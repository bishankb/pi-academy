@extends('layouts.exam')

@section('content')
	<div class="show_result">
		<div class="panel panel-default" >
			<div class="panel-heading">Your Result: </div>
			<div class="panel-body">
				<span>You have attempted: Short Answer = {{ $attempted1Mark }} and Long Answer = {{ $attempted2Mark }}</span><br><br>
				<span>Among them Correct Short Answers: {{ $correct1Mark }} and Correct Long Answers: {{ $correct2Mark }}</span><br><br>
				<span>You have scored: {{ $score }}</span><br/><br/><br/>			
			</div>
		</div>

		<div class="panel panel-default" >
        	<div class="panel-heading"><strong>Table View: </strong></div>
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
	                        <td>{{ $attempted1Mark }}</td>
	                        <td>{{ $correct1Mark }}</td>
							<td>{{ $attempted_question_separate['total2Marks'] }}</td>
	                        <td>{{ $attempted2Mark }}</td>
	                        <td>{{ $correct2Mark }}</td>
	                        <td>{{ $score }}</td>
	                    </tr>
					</tbody>
				</table>
			</div>
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading">Your Attempted Questions: ({{ $attempted }} out of {{ count($all_questions) }}) :</div>
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
					<button class="btn btn-primary see-more" data-toggle="collapse" data-target="#attemptedQuestions">See More &raquo;</button>
				@endif
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">All Question And Answers: </div>
			<div class="panel-body">
				@foreach($all_questions as $key => $all_question)
					@if ($key <= 3)
						<div class="result-question-answer">
							<div class="result-question">Q{{ $loop->iteration }}) {!! $all_question->question !!}</div>
							<div class="result-option">Option:-
		                        <ol type="a">
	                        		<li>{!! $all_question->option1 !!}</li>
	                        		<li>{!! $all_question->option2 !!}</li>
	                        		<li>{!! $all_question->option3 !!}</li>
	                        		<li>{!! $all_question->option4 !!}</li>
	                        	</ol>
	                        </div>
							<div class="result-answer">Ans:- 
								@if($all_question->correct_answer == 1)
									{!! $all_question->option1 !!}
								@elseif($all_question->correct_answer == 2)
									{!! $all_question->option2 !!}
								@elseif($all_question->correct_answer == 3)
									{!! $all_question->option3 !!}
								@else
									{!! $all_question->option4 !!}
								@endif
							</div>
							@isset($all_question->solution)
	                            <div class="result-solution">Solution:-
	                                {!! $all_question->solution !!}
	                            </div>
	                        @endisset
						</div>
					@endif
				@endforeach
				<div class="collapse" id="allQuestions">
					@foreach($all_questions as $key => $all_question)
						@if ($key >= 4)
							<div class="result-question-answer">
								@if(isset($all_question->set->paragraph) && $all_question->subject == array_flip($subjects)['English'] && $all_question->marks == array_flip($marks)['2 Marks'])
	                                @if($all_questions->where('subject', array_flip($subjects)['English'])->where('marks', array_flip($marks)['2 Marks'])->first()->id == $all_question->id)
	                                    <div class="result-paragraph">Paragraph:-<br>
	                                        {!! $all_question->set->paragraph->paragraph !!}
	                                    </div>
	                                @endif
	                            @endif

								<div class="result-question">Q{{ $loop->iteration }}) {!! $all_question->question !!}</div>
								<div class="result-option">Option:-
		                        	<ol type="a">
		                        		<li>{!! $all_question->option1 !!}</li>
		                        		<li>{!! $all_question->option2 !!}</li>
		                        		<li>{!! $all_question->option3 !!}</li>
		                        		<li>{!! $all_question->option4 !!}</li>
		                        	</ol>
		                        </div>
								<div class="result-answer">Ans:- 
									@if($all_question->correct_answer == 1)
										{!! $all_question->option1 !!}
									@elseif($all_question->correct_answer == 2)
										{!! $all_question->option2 !!}
									@elseif($all_question->correct_answer == 3)
										{!! $all_question->option3 !!}
									@else
										{!! $all_question->option4 !!}
									@endif
								</div>
								@isset($all_question->solution)
		                            <div class="result-solution">Solution:-
		                                {!! $all_question->solution !!}
		                            </div>
		                        @endisset
							</div>
						@endif
					@endforeach
				</div>
				<button class="btn btn-primary see-more" data-toggle="collapse" data-target="#allQuestions">See More &raquo;</button>
			</div>
		</div>
		<a href="{{ route('exam.home') }}" class="btn btn-success btn-finish">Finish &#10003;</a>
	</div>
@endsection
