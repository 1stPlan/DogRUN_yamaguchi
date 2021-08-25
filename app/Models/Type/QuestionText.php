<?php

namespace App\Models\Type;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionText extends Model
{
  use SoftDeletes;
  protected $table = 'question_texts';

  protected $primaryKey = 'id';

  protected $guarded = [];

  protected $dates = [
    'deleted_at'
  ];

  protected $fillable = [
    'question_text'
  ];

  
  /**
   * @param Builder $query
   * @param $id
   * @return \Illuminate\Database\Query\Builder
   */
  public function scopeQuestionTextId(Builder $query, $id)
  {
    return $query->where($this->table . '.id', $id);
  }
}
