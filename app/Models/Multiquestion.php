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
class Multiquestion extends Model
{
    use SoftDeletes;

    protected $fillable = ['question', 'question_image', 'score','userid','courseid','questiontype','questionpage',
                            'questionorder','width','indent','fontsize','titlelocation','imagefit','imagewidth','imgrheight','columncount','content','logic'];
   

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */



}
