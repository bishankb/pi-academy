<script type="text/javascript">
	$(document).ready(function(){	
		pageSize = 20;
		displayPaginationTill = (($('.question-answers').length)/pageSize);
		displayPaginationTill = Math.ceil(displayPaginationTill) - 1;

		showPage = function(page) {
		    $(".question-answers").hide();
		    
		    $(".question-answers").each(function(n) {
		        
		        if (n >= pageSize * (page - 1) && n < pageSize * page)
		            $(this).show();
		    });        
		}
		showPage(1);  
	    $('#prev').click(prevPage);
	    $('#next').click(nextPage);

	});

	var page = 1;
	function prevPage() {
	    if (page === 1) {
	        page = Math.floor($('.pagination .question-answers').length/pageSize);
	    } else {
	    	$('#next-a').css({ display: "inline" });
	        $('#next-span').hide();
	    	if(page == 2) {
	    		$('#prev-a').hide();
	        	$('#prev-span').css({ display: "inline" });
	    	}
	        page--;
	    }
	    showPage(page);
	}

	function nextPage() {
	    if (page == Math.floor($('.pagination .question-answers').length/pageSize)) {
	        page = 1;
	    } else {
	        $('#prev-a').css({ display: "inline" });
	        $('#prev-span').hide();
	    	if(page == displayPaginationTill) {
	    		$('#next-a').hide();
	        	$('#next-span').css({ display: "inline" });
	    	}
	        page++;
	    }
	    showPage(page);
	}

	$('#top-page').click(function() {
		$('body,html').animate({
			scrollTop: 0
		}, 600);
		return false;
	});

	sessionTargetDate = localStorage.getItem("sessionTargetDate"+{{$set->id}}+{{Auth::user()->id}});

	if(!sessionTargetDate) {
		target_date = new Date().getTime()+7201108;
	} else {
	    target_date = sessionTargetDate;	    
	}

    localStorage.setItem("sessionTargetDate"+{{$set->id}}+{{Auth::user()->id}}, target_date);

    var days, hours, minutes, seconds;
     
    var a;
    setInterval(function () {    
        var current_date = new Date().getTime();
        var seconds_left = (target_date - current_date) / 1000;
        a = seconds_left;

        days = parseInt(seconds_left / 86400);
        seconds_left = seconds_left % 86400;
         
        hours = parseInt(seconds_left / 3600);
        seconds_left = seconds_left % 3600;
         
        minutes = parseInt(seconds_left / 60);
        seconds = parseInt(seconds_left % 60);

        countdown = hours + " : " + minutes + " : " + seconds;
        $('#countdown').html(countdown);


        if(seconds==0 && minutes==0 && hours==0){
        	localStorage.removeItem('sessionTargetDate'+{{$set->id}}+{{Auth::user()->id}});
        	localStorage.removeItem('attemptedQuestions'+{{$set->id}}+{{Auth::user()->id}});
			localStorage.removeItem('sessionRadioCount'+{{$set->id}}+{{Auth::user()->id}});
			localStorage.removeItem('sessionAllQuestionNumbers'+{{$set->id}}+{{Auth::user()->id}});
            document.forms["questionAnswerForm"].submit();
        }
     
    }, 1000);

    var minutes = {{ config('pi-academy.question_timeout') }}; 
	var now = new Date().getTime();
	var setupTime = localStorage.getItem('setupTime');
	if (setupTime == null) {
	    localStorage.setItem('setupTime', now)
	} else {
	    if(now - setupTime >= minutes*60*1000) {
	        localStorage.removeItem('attemptedQuestions'+{{$set->id}}+{{Auth::user()->id}});
			localStorage.removeItem('sessionRadioCount'+{{$set->id}}+{{Auth::user()->id}});
			localStorage.removeItem('sessionAllQuestionNumbers'+{{$set->id}}+{{Auth::user()->id}});
			localStorage.removeItem('sessionTargetDate'+{{$set->id}}+{{Auth::user()->id}});
	    }
	}

    var showRemaingQuestion = {{ config('pi-academy.show_remaing_question') }};
    var all_questions = {!! json_encode($all_questions, JSON_HEX_TAG) !!};
	var allQuestionNumbers = [];
	$.each(all_questions, function(key, value) {
		 allQuestionNumbers.push(key+1) 
	});
	var attemptedQuestions = [];

	var getAttemptedQuestions = JSON.parse(localStorage.getItem("attemptedQuestions"+{{$set->id}}+{{Auth::user()->id}}));

	if(getAttemptedQuestions) {
		getAttemptedQuestions.map(function(question) {
			$("input[class=question-option" + question.attemptedQuestion + "][value=" + question.choosenAnswer + "]").prop('checked', true);
		})
	}

	var	sessionRadioCount = localStorage.getItem("sessionRadioCount"+{{$set->id}}+{{Auth::user()->id}});
	if(sessionRadioCount){
		$('.question-answered').append("'"+sessionRadioCount+"'");

		if(sessionRadioCount >= showRemaingQuestion) {
			$('.unanswered-questions').show();
			$('.unanswered-questions').css("padding-top", "4px");
			if(sessionRadioCount == 100) {
				$('.questionsNumbers').hide();
				$('.attempted-all-questions').show();
			}
		}
	} else {
	    $('.question-answered').append("'"+0+"'");		
	}

	var	sessionAllQuestionNumbers = JSON.parse(localStorage.getItem("sessionAllQuestionNumbers"+{{$set->id}}+{{Auth::user()->id}}));
	if(sessionAllQuestionNumbers){
		$('.questionsNumbers').html(sessionAllQuestionNumbers.join(', '));
	}

    @foreach($all_questions as $key=>$all_question)
    	$('.question-option'+'{{$key + 1}}').click(function (event) {
      		var all_question = {{ $key + 1 }};

      		getAttemptedQuestions = JSON.parse(localStorage.getItem("attemptedQuestions"+{{$set->id}}+{{Auth::user()->id}}));

      		if(!getAttemptedQuestions) {
      			attemptedQuestions = [];
      		} else {
      			attemptedQuestions = getAttemptedQuestions;
      		}

        	pos = attemptedQuestions.map(function(question) {
        		return question.attemptedQuestion;
        	}).indexOf(all_question);

      		if(pos < 0) {
      			attemptedQuestions.push({
	      			'attemptedQuestion' : all_question,
	      			'choosenAnswer' : event.target.value
	      		});
      		} else {
      			attemptedQuestions.map(function(question) {
	        		if(question.attemptedQuestion == all_question) {
	        			question.choosenAnswer = event.target.value;
	        		}
	        	})

      		}
      		localStorage.setItem("attemptedQuestions"+{{$set->id}}+{{Auth::user()->id}}, JSON.stringify(attemptedQuestions));

      		sessionAllQuestionNumbers = JSON.parse(localStorage.getItem("sessionAllQuestionNumbers"+{{$set->id}}+{{Auth::user()->id}}));

      		if(!sessionAllQuestionNumbers) {
      			allQuestionNumbers = allQuestionNumbers;
      		} else {
      			allQuestionNumbers = sessionAllQuestionNumbers;

      		}

      		allQuestionNumbers = allQuestionNumbers.filter(function(answer) {
            	return answer !== all_question;
            });

			$('.questionsNumbers').html(allQuestionNumbers.join(', '));

      		localStorage.setItem("sessionAllQuestionNumbers"+{{$set->id}}+{{Auth::user()->id}}, JSON.stringify(allQuestionNumbers));

	    	radioCount = $('#question-option:checked').length;

			$('.question-answered').html("'"+radioCount+"'");

			localStorage.setItem("sessionRadioCount"+{{$set->id}}+{{Auth::user()->id}}, radioCount);

			if(radioCount >= showRemaingQuestion) {
				$('.unanswered-questions').show();
				$('.unanswered-questions').css("padding-top", "4px");
				if(radioCount == 100) {
					$('.questionsNumbers').hide();
					$('.attempted-all-questions').show();
				}
			}
			 
		});
	@endforeach

	$('#questionAnswerForm').submit(function(){
		localStorage.removeItem('attemptedQuestions'+{{$set->id}}+{{Auth::user()->id}});
		localStorage.removeItem('sessionRadioCount'+{{$set->id}}+{{Auth::user()->id}});
		localStorage.removeItem('sessionAllQuestionNumbers'+{{$set->id}}+{{Auth::user()->id}});
		localStorage.removeItem("sessionTargetDate"+{{$set->id}}+{{Auth::user()->id}});
	});
</script>
	