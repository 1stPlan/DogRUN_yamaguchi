<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventSearch extends Model
{
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
    ];

    protected $table = 'event_searches';

    protected $primaryKey = 'id';

    protected $fillable = [
        'event_id',
        'category_id',
    ];

    /**
     * belongsTo
     */
    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

    public function eventSearchCategory()
    {
        return $this->belongsTo('App\Models\EventSearchCategory', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeId(Builder $query, $userId)
    {
        return $query->where($this->table.'.id', $userId);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeEventId(Builder $query, $eventId)
    {
        return $query->where($this->table.'.event_id', $eventId);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeCategoryId(Builder $query, $categoryId)
    {
        return $query->where($this->table.'.category_id', $categoryId);
    }
}
