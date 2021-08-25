<?php

namespace App\Models\Type;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
  use SoftDeletes;

  protected $table = 'questions';

  protected $primaryKey = 'id';

  protected $guarded = [];

  protected $dates = [
    'deleted_at'
  ];

  protected $fillable = [
    'next_text_id',
    'choice',
    'parent_id',
    'question_set_id',
    'asc_order'
  ];

  
  /**
   * @param Builder $query
   * @param $userId
   * @return \Illuminate\Database\Query\Builder
   */

  public function scopeQuestionSetioId(Builder $query, $question_set_id)
  {
    return $query->where($this->table . '.question_set_id', $question_set_id);
  }

  public function scopeParentId(Builder $query, $parentId)
  {
    return $query->where($this->table . '.parent_id', $parentId);
  }

  public function scopeQuestionId(Builder $query, $id)
  {
    return $query->where($this->table . '.id', $id);
  }
}
