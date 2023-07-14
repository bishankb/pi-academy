@extends('layouts.exam')

@section('content')
	<div class="welcome-panel">
	    <h3>Welcome {{ Auth::user()->username }} ! </h3>
	    <h5>Online Examination System</h5>
	</div>

	<div class="sets">
		<h4 class="sectio-h4">Please Select A Set</h4>
		<div class="row">
			@foreach($question_sets as $key => $question_set)
				<div class="col-md-3 col-sm-4 col-xs-6">
			        <a href="#" onclick="event.preventDefault();" data-toggle="modal" data-target="#setModal{{$question_set->id}}">
						<div class="set-box" style="background-color: {{ $colors[$key] }};">
					        <span>{{ $question_set->name }}</span>
					    </div>
			        </a>
				</div>
				<div id="setModal{{$question_set->id}}" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Confirm Start?</h4>
							</div>
							<div class="modal-body">
								<p style="font-size: 14px;">Are your sure you want to start the exam of {{ $question_set->name }}?</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							    <a href="{{ route('exam.before-exam', $question_set->slug)}}" class="btn btn-start-exam">Start</a>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection