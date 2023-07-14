<script type="text/javascript">
    var attemptedQuestionSeparate = {!! json_encode($attempted_question_separate, JSON_HEX_TAG) !!};

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
                "correct": attemptedQuestionSeparate.correct1Aptitude,
                "inCorrect": attemptedQuestionSeparate.attempted1Aptitude - attemptedQuestionSeparate.correct1Aptitude,
                "unAttempted": attemptedQuestionSeparate.total1Aptitude - attemptedQuestionSeparate.attempted1Aptitude,
            }, 
            {
                "subject": "Chemistry",
                "correct": attemptedQuestionSeparate.correct1Chemistry,
                "inCorrect": attemptedQuestionSeparate.attempted1Chemistry - attemptedQuestionSeparate.correct1Chemistry,
                "unAttempted": attemptedQuestionSeparate.total1Chemistry - attemptedQuestionSeparate.attempted1Chemistry,
            },
            {
                "subject": "English",
                "correct": attemptedQuestionSeparate.correct1English,
                "inCorrect": attemptedQuestionSeparate.attempted1English - attemptedQuestionSeparate.correct1English,
                "unAttempted": attemptedQuestionSeparate.total1English - attemptedQuestionSeparate.attempted1English,
            },
            {
                "subject": "Math",
                "correct": attemptedQuestionSeparate.correct1Math,
                "inCorrect": attemptedQuestionSeparate.attempted1Math - attemptedQuestionSeparate.correct1Math,
                "unAttempted": attemptedQuestionSeparate.total1Math - attemptedQuestionSeparate.attempted1Math,
            },
            {
                "subject": "Physics",
                "correct": attemptedQuestionSeparate.correct1Physics,
                "inCorrect": attemptedQuestionSeparate.attempted1Physics - attemptedQuestionSeparate.correct1Physics,
                "unAttempted": attemptedQuestionSeparate.total1Physics - attemptedQuestionSeparate.attempted1Physics,
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
                "color": "#000000",
                "fillColors" : 'green',
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
                "correct": attemptedQuestionSeparate.correct2Aptitude,
                "inCorrect": attemptedQuestionSeparate.attempted2Aptitude - attemptedQuestionSeparate.correct2Aptitude,
                "unAttempted": attemptedQuestionSeparate.total2Aptitude - attemptedQuestionSeparate.attempted2Aptitude,
            }, 
            {
                "subject": "Chemistry",
                "correct": attemptedQuestionSeparate.correct2Chemistry,
                "inCorrect": attemptedQuestionSeparate.attempted2Chemistry - attemptedQuestionSeparate.correct2Chemistry,
                "unAttempted": attemptedQuestionSeparate.total2Chemistry - attemptedQuestionSeparate.attempted2Chemistry,
            },
            {
                "subject": "English",
                "correct": attemptedQuestionSeparate.correct2English,
                "inCorrect": attemptedQuestionSeparate.attempted2English - attemptedQuestionSeparate.correct2English,
                "unAttempted": attemptedQuestionSeparate.total2English - attemptedQuestionSeparate.attempted2English,
            },
            {
                "subject": "Math",
                "correct": attemptedQuestionSeparate.correct2Math,
                "inCorrect": attemptedQuestionSeparate.attempted2Math - attemptedQuestionSeparate.correct2Math,
                "unAttempted": attemptedQuestionSeparate.total2Math - attemptedQuestionSeparate.attempted2Math,
            },
            {
                "subject": "Physics",
                "correct": attemptedQuestionSeparate.correct2Physics,
                "inCorrect": attemptedQuestionSeparate.attempted2Physics - attemptedQuestionSeparate.correct2Physics,
                "unAttempted": attemptedQuestionSeparate.total2Physics - attemptedQuestionSeparate.attempted2Physics,
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
                "color": "#000000",
                "fillColors" : 'green',
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