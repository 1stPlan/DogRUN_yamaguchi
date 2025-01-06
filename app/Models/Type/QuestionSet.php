<?php

namespace App\Models\Type;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionSet extends Model
{
    use SoftDeletes;

    protected $table = 'question_sets';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $dates = [
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'img_url',
        'reason',
        'features',
    ];

    /**
     * @param  $Id
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeQuestionSetId(Builder $query, $id)
    {
        return $query->where($this->table.'.id', $id);
    }
}
