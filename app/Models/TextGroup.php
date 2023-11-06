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
class TextGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['content', 'score','user_id','logic','text_order'];

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

 
        }

}
