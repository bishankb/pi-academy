@extends('layouts.exam')

@section('exam-style')
	<style type="text/css">
		#prev-a, #next-span {
			display: none;
		}

		.unanswered-questions, .attempted-all-questions {
			display: none;
		}

		#nex-a {
			display: inline;
		}
	</style>
@endsection

@section('content')
	<div class="exam-notice">
		<h4 class="sectio-h4">{{ $set->name}} Exam</h4>
		<div style="float: right;">
			<div class="exam-information">
				<div class="row">
					<div class="col-md-8">
						<h4>{{ Auth::user()->username }} @isset(Auth::user()->registration_number) ({{ Auth::user()->registration_number }}) @endisset</h4>
						<h6>Time Remaining: <span style="font-size: 18px" id="countdown"></span></h6>
					</div>
					<div class="col-md-4">
						@if(isset(Auth::user()->student->image1))
							<img src="/storage/media/student-registration-image1/{{ Auth::user()->student->id }}/thumbnail/{{ Auth::user()->student->image1->filename }}">
						@endif
					</div>
				</div>
				<h5>You have answered <span class="question-answered"></span> out of '{{ count($all_questions)}}'</h5>
				<h6 class="unanswered-questions">
					<span style="font-size: 14px">View 
						<a href="#" onclick="event.preventDefault();" data-toggle="modal" data-target="#remainingQuestionModal">unanswered</a> questions
					</span>
				</h6>
				
			</div>
		</div>
		<div class="onlineExam">
			<form method="POST" action="{{ route('exam.check', $set->slug) }}" id="questionAnswerForm">
        		{{ csrf_field() }}
				<div class="question-section">
	    			@foreach($one_mark_questions as $oneMark_question_number=>$one_mark_question)
	    				<div class="question-answers">
		    				@if($oneMark_question_number == 0)
								<h4 id="oneMark-h4">Group A [1 Mark Question From 1 To {{ count($one_mark_questions) }} ]</h4><br>
							@endif

							<div class="question">
								{{ $loop->iteration }}) {!! $one_mark_question->question !!}
							</div>
							<br>
							<div class="answer">
								@php
									$answers = [
								        ['id' => 1, 'option' => $one_mark_question->option1],
								        ['id' => 2, 'option' => $one_mark_question->option2],
								        ['id' => 3, 'option' => $one_mark_question->option3],
								        ['id' => 4, 'option' => $one_mark_question->option4]
								    ];
								@endphp
								@foreach($answers as $answer)
									<div class="question-option-div">
										<input id="question-option" class="question-option{{$oneMark_question_number + 1}}" type="radio"  name="{{ $one_mark_question->id }}" value="{{ $answer['id'] }}">
											{!! $answer['option'] !!}
									</div>
								@endforeach
							</div>
							<br>
						</div>
					@endforeach

					@foreach($two_mark_questions as $twoMark_question_number=>$two_mark_question)
	    				<div class="question-answers">
		    				@if($twoMark_question_number == 0)
								<h4>Group B [2 Marks Question From {{ count($one_mark_questions) + 1 }} To {{ count($one_mark_questions) + count($two_mark_questions) }} ]</h4><br>
							@endif

							@if(isset($set->paragraph->paragraph) && $two_mark_question->subject == array_flip($subjects)['English'])
								@if($two_mark_questions->where('marks', array_flip($marks)['2 Marks'])->where('subject', array_flip($subjects)['English'])->first()->id == $two_mark_question->id)
									<h4>Read the passage carefully and select the best alternatives:</h4> 
									<h4 class="paragraph-h4">{!! $set->paragraph->paragraph !!}</h4><br>
								@endif
							@endif

							<div class="question">
								{{ $loop->iteration + count($one_mark_questions) }}) {!! $two_mark_question->question !!}
							</div>
							<br>
							<div class="answer">
								@php
									$answers = [
								        ['id' => 1, 'option' => $two_mark_question->option1],
								        ['id' => 2, 'option' => $two_mark_question->option2],
								        ['id' => 3, 'option' => $two_mark_question->option3],
								        ['id' => 4, 'option' => $two_mark_question->option4]
								    ];
								@endphp
								@foreach($answers as $answer)
									<div class="question-option-div">
										<input id="question-option" class="question-option{{$twoMark_question_number + 1 + count($one_mark_questions)}}" type="radio" name="{{$two_mark_question->id }}" value="{{ $answer['id'] }}">
											{!! $answer['option'] !!}
									</div>
								@endforeach
							</div>
							<br>
						</div>
					@endforeach

				</div>
				<ul class="pagination" role="navigation" id="pages">
    
	                 <li class="page-item" id ="prev-a">
	               		<a class="page-link" href="#" id="prev" rel="prev">« Previous</a>
	            	</li>

	            	 <li class="page-item disabled" id ="prev-span" aria-disabled="true">
	                	<span class="page-link"  id="prev">« Previous</span>
	            	</li>

	                <li class="page-item" id ="next-a">
		                <a class="page-link" href="#" id="next" rel="next">Next »</a>
		            </li>

		            <li class="page-item disabled" id ="next-span" aria-disabled="true">
	                	<span class="page-link" id="next">Next »</span>
	            	</li>
	            </ul>
	            <div class="form-action">
	            	 <button type="button" class="btn btn-primary btn-exam" data-toggle="modal" data-target="#submitExamModal">Submit</button>

	            	<button type="button" class="btn btn-primary btn-exam pull-right" id="top-page">Go Top
	            		<i class="fa fa-long-arrow-up"></i>
	            	</button>
	            </div>

	            <div id="submitExamModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h5>You have answered <span class="question-answered"></span> out of '{{ count($all_questions)}}' questions. You won't be able to retake the exam once it is submitted. Do you want to submit anyway?</h5>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button  type="submit" class="btn btn-primary btn-start-exam">Ok</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div id="remainingQuestionModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="questionsNumbers"></h5>
					<h5 class="attempted-all-questions">You have answered all questions. Best of luck</h5>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-exam pull-right" data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('exam-script')

    @include('exam._take_exam_js')
    
@endsection