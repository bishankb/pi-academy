<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\ExaminationQuesion;
use App\ExaminationQuestion;
use App\QuestionSet;

class ExaminationQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $subjects = ExaminationQuestion::Subjects;
        $marks = ExaminationQuestion::Marks;
        $options = ExaminationQuestion::Options;

        return [
            'id' => $this->id,
            'subject' => $subjects[$this->subject],
            'marks' => $marks[$this->marks],
            'question' => $this->question,
            'option1' => $this->option1,
            'option2' => $this->option2,
            'option3' => $this->option3,
            'option4' => $this->option4,
            'correct_answer' => $options[$this->correct_answer],
            'solution' => $this->solution,
          ];
    }
}