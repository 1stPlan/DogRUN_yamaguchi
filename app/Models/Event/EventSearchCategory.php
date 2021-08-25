<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EventSearchCategory extends Model
{
  use SoftDeletes;

  protected $dates = [
      'deleted_at',
  ];

  protected $table = 'event_search_categories';

  protected $primaryKey = 'id';

  protected $fillable = [
      'category',
  ];


  /**
   * hasMany
   */
  public function eventSearches()
  {
      return $this->hasMany('App\Models\EventSearch', 'category_id');
  }

  /**
   * @param Builder $query
   * @param $userId
   * @return \Illuminate\Database\Query\Builder
   */
  public function scopeId(Builder $query, $userId) {
      return $query->where($this->table.'.id', $userId);
  }

}
