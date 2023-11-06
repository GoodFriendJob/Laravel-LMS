<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

/**
 * Class Question
 *
 * @package App
 * @property text $question
 * @property string $question_image
 * @property integer $score
 */
class Question extends Model
{
    use SoftDeletes;

    protected $fillable = ['question', 'help_info', 'questionimage', 'score','userid','test_id','questiontype','questionpage',
    'questionorder','width','indent','required','more_than_one_answer','fontsize','titlelocation','imagefit',
    'imagewidth','imageheight','columncount','content','logic','state',
    'help_info_location','max_width','min_width','size', 'color1', 'color2'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        // if (auth()->check()) {
        //     if (auth()->user()->hasRole('teacher')) {
        //         static::addGlobalScope('filter', function (Builder $builder) {
        //             $courses = auth()->user()->courses->pluck('id');
        //             $builder->whereHas('tests', function ($q) use ($courses) {
        //                 $q->whereIn('tests.course_id', $courses);
        //             });
        //         });
        //     }
        // }

        static::deleting(function ($question) { // before delete() method call this
            if ($question->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/' . $question->question_image))) {
                    File::delete(public_path('/storage/uploads/' . $question->question_image));
                }
            }
        });

    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setScoreAttribute($input)
    {
        $this->attributes['score'] = $input ? $input : null;
    }

    public function options()
    {
        return $this->hasMany('App\Models\QuestionsOption');
    }

    public function isAttempted($result_id){
        $result = TestsResultsAnswer::where('tests_result_id', '=', $result_id)
            ->where('question_id', '=', $this->id)
            ->first();
        if($result != null){
            return true;
        }
        return false;
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'question_test');
    }


}
