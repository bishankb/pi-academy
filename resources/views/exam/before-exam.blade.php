@extends('layouts.exam')

@section('content')
	<div class="welcome-panel">
	    <h3>Welcome {{ Auth::user()->username }} ! </h3>
	    <h5>Online Examination System</h5>
	</div>

	<div class="exam-notice">
		<h4 class="sectio-h4">Examination Notice</h4>
		<ul>
			<li>You have to check radio button on correct option.</li>
			<li>If the selected option is wrong 10% negative marking will be applied.</li>
			<li>Click on next button to navigate to the next page.</li>
			<li>Click on previous button to navigate to the previous page.</li>
			<li>You can change your option during the examination period.</li>
			<li>Information along with time remaning, total attempted and total questions will be displayed at the top of your page.</li>
		</ul>
	</div>

	<div class="sets">
		<h4 class="sectio-h4">You can now take the exam</h4>
		<div class="well">
			<div class="text-center">
				<a href="#" onclick="event.preventDefault();" data-toggle="modal" data-target="#examModal" class="btn btn-login">
					<i style="margin-right: 5px;" class="fa fa-pencil"></i>Take Examination
		        </a>
		    </div>
	        <div id="examModal" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Confirm Start?</h4>
						</div>
						<div class="modal-body">
							<p style="font-size: 14px;">Are your sure you want to start the exam?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						    <a href="{{ route('exam.take-exam', $set->slug)}}" class="btn btn-start-exam">Start</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection