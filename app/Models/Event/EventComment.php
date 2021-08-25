<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventComment extends Model
{
  use SoftDeletes;

  protected $primaryKey = 'id';
  protected $fillable = [
    'body',
    'user_id',
    'event_post_id'
  ];

  protected $guarded = [];


  /**
   * belongsTo
   */
  public function event_post()
  {
    return $this->belongsTo('App\Models\Event\EventCommentPost');
  }

  public function users()
  {
    return $this->belongsTo('App\Models\User');
  }
  
  /**
  * @param Builder $query
  * @param $id
  * @return \Illuminate\Database\Query\Builder
  */
 public function scopeId(Builder $query, $id) {
     return $query->where($this->table.'.id', $id);
 }

  /**
   * @param Builder $query
   * @param $eventId
   * @return \Illuminate\Database\Query\Builder
   */
  public function scopePostId(Builder $query, $postId)
  {
    return $query->where($this->table . '.post_id', $postId);
  }
}
