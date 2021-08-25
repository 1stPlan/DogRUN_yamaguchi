<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
  use SoftDeletes;

  protected $primaryKey = 'id';
  protected $fillable = [
    'ip_address',
    'post_id'
  ];

  protected $guarded = [];


  /**
   * belongsTo
   */
  public function post()
  {
    return $this->belongsTo('App\Models\Post\Post');
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

  /**
   * @param Builder $query
   * @param $eventId
   * @return \Illuminate\Database\Query\Builder
   */
  public function scopeIpAddress(Builder $query, $ipAddress)
  {
    return $query->where($this->table . '.ip_address', $ipAddress);
  }
}
