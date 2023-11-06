<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class QuestionsOption
 *
 * @package App
 * @property string $question
 * @property text $option_text
 * @property tinyInteger $correct
 */
class QuestionsOption extends Model
{
    use SoftDeletes;

    protected $fillable = ['option_text', 'correct', 'explanation', 'question_id'];


    /**
     * Set to null if empty
     * @param $input
     */
    public function setQuestionIdAttribute($input)
    {
        $this->attributes['question_id'] = $input ? $input : null;
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id')->withTrashed();
    }

    public function answered($result_id)
    {
        $result = TestsResultsAnswer::where('tests_result_id', '=', $result_id)
            ->where('option_id', '=', $this->id)
            ->first();

        if ($result) {
            if ($result->correct == 1) {
                return 1;
            } elseif($result->correct == 0){
                return 2;
            }
        }
        return 0;
    }

}
