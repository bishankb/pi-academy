<script type="text/javascript">
    var totalAttemptedQuestionSeparate = {!! json_encode($totalAttempted_question_separate, JSON_HEX_TAG) !!};
    
    var chart = AmCharts.makeChart("oneMarkChart", {
        "type": "serial",
        "theme": "none",
        "legend": {
            "horizontalGap": 10,
            "maxColumns": 1,
            "position": "right",
            "useGraphSettings": true,
            "markerSize": 10,
            "textClickEnabled": true,
            "switchable": true
        },
        "dataProvider": [
            {
                "subject": "Aptitude",
                "correct": totalAttemptedQuestionSeparate.correct1Aptitude,
                "inCorrect": totalAttemptedQuestionSeparate.attempted1Aptitude - totalAttemptedQuestionSeparate.correct1Aptitude,
                "unAttempted": totalAttemptedQuestionSeparate.total1Aptitude - totalAttemptedQuestionSeparate.attempted1Aptitude,
            }, 
            {
                "subject": "Chemistry",
                "correct": totalAttemptedQuestionSeparate.correct1Chemistry,
                "inCorrect": totalAttemptedQuestionSeparate.attempted1Chemistry - totalAttemptedQuestionSeparate.correct1Chemistry,
                "unAttempted": totalAttemptedQuestionSeparate.total1Chemistry - totalAttemptedQuestionSeparate.attempted1Chemistry,
            },
            {
                "subject": "English",
                "correct": totalAttemptedQuestionSeparate.correct1English,
                "inCorrect": totalAttemptedQuestionSeparate.attempted1English - totalAttemptedQuestionSeparate.correct1English,
                "unAttempted": totalAttemptedQuestionSeparate.total1English - totalAttemptedQuestionSeparate.attempted1English,
            },
            {
                "subject": "Math",
                "correct": totalAttemptedQuestionSeparate.correct1Math,
                "inCorrect": totalAttemptedQuestionSeparate.attempted1Math - totalAttemptedQuestionSeparate.correct1Math,
                "unAttempted": totalAttemptedQuestionSeparate.total1Math - totalAttemptedQuestionSeparate.attempted1Math,
            },
            {
                "subject": "Physics",
                "correct": totalAttemptedQuestionSeparate.correct1Physics,
                "inCorrect": totalAttemptedQuestionSeparate.attempted1Physics - totalAttemptedQuestionSeparate.correct1Physics,
                "unAttempted": totalAttemptedQuestionSeparate.total1Physics - totalAttemptedQuestionSeparate.attempted1Physics,
            },
             
        ],

        "valueAxes": [
            {
                "stackType": "regular",
                "axisAlpha": 0.5,
                "gridAlpha": 0
            }
        ],

        "graphs": [
            {
                "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                "fillAlphas": 0.8,
                "labelText": "[[value]]",
                "lineAlpha": 0.3,
                "title": "Correct",
                "type": "column",
                "fillColors" : 'green',
                "color": "#000000",
                "valueField": "correct"
            },
            {
                "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                "fillAlphas": 0.8,
                "labelText": "[[value]]",
                "lineAlpha": 0.3,
                "title": "Incorrect",
                "type": "column",
                "fillColors" : 'red',
                "color": "#000000",
                "valueField": "inCorrect"
            },
            {
                "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                "fillAlphas": 0.8,
                "labelText": "[[value]]",
                "lineAlpha": 0.3,
                "title": "UnAttempted",
                "type": "column",
                "fillColors" : 'grey',
                "color": "#000000",
                "valueField": "unAttempted"
            },
        ],

        "categoryField": "subject",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "gridAlpha": 0,
        }
    },0);

    var chart = AmCharts.makeChart("twoMarkChart", {
        "type": "serial",
        "theme": "none",
        "legend": {
            "horizontalGap": 10,
            "maxColumns": 1,
            "position": "right",
            "useGraphSettings": true,
            "markerSize": 10,
            "textClickEnabled": true,
            "switchable": true
        },
        "dataProvider": [
            {
                "subject": "Aptitude",
                "correct": totalAttemptedQuestionSeparate.correct2Aptitude,
                "inCorrect": totalAttemptedQuestionSeparate.attempted2Aptitude - totalAttemptedQuestionSeparate.correct2Aptitude,
                "unAttempted": totalAttemptedQuestionSeparate.total2Aptitude - totalAttemptedQuestionSeparate.attempted2Aptitude,
            }, 
            {
                "subject": "Chemistry",
                "correct": totalAttemptedQuestionSeparate.correct2Chemistry,
                "inCorrect": totalAttemptedQuestionSeparate.attempted2Chemistry - totalAttemptedQuestionSeparate.correct2Chemistry,
                "unAttempted": totalAttemptedQuestionSeparate.total2Chemistry - totalAttemptedQuestionSeparate.attempted2Chemistry,
            },
            {
                "subject": "English",
                "correct": totalAttemptedQuestionSeparate.correct2English,
                "inCorrect": totalAttemptedQuestionSeparate.attempted2English - totalAttemptedQuestionSeparate.correct2English,
                "unAttempted": totalAttemptedQuestionSeparate.total2English - totalAttemptedQuestionSeparate.attempted2English,
            },
            {
                "subject": "Math",
                "correct": totalAttemptedQuestionSeparate.correct2Math,
                "inCorrect": totalAttemptedQuestionSeparate.attempted2Math - totalAttemptedQuestionSeparate.correct2Math,
                "unAttempted": totalAttemptedQuestionSeparate.total2Math - totalAttemptedQuestionSeparate.attempted2Math,
            },
            {
                "subject": "Physics",
                "correct": totalAttemptedQuestionSeparate.correct2Physics,
                "inCorrect": totalAttemptedQuestionSeparate.attempted2Physics - totalAttemptedQuestionSeparate.correct2Physics,
                "unAttempted": totalAttemptedQuestionSeparate.total2Physics - totalAttemptedQuestionSeparate.attempted2Physics,
            },
             
        ],

        "valueAxes": [
            {
                "stackType": "regular",
                "axisAlpha": 0.5,
                "gridAlpha": 0
            }
        ],

        "graphs": [
            {
                "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                "fillAlphas": 0.8,
                "labelText": "[[value]]",
                "lineAlpha": 0.3,
                "title": "Correct",
                "type": "column",
                "fillColors" : 'green',
                "color": "#000000",
                "valueField": "correct"
            },
            {
                "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                "fillAlphas": 0.8,
                "labelText": "[[value]]",
                "lineAlpha": 0.3,
                "title": "Incorrect",
                "type": "column",
                "fillColors" : 'red',
                "color": "#000000",
                "valueField": "inCorrect"
            },
            {
                "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                "fillAlphas": 0.8,
                "labelText": "[[value]]",
                "lineAlpha": 0.3,
                "title": "UnAttempted",
                "type": "column",
                "fillColors" : 'grey',
                "color": "#000000",
                "valueField": "unAttempted"
            },
        ],

        "categoryField": "subject",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "gridAlpha": 0,
        }
    },0);
</script>