<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventPost extends Model
{
    use SoftDeletes;

    protected $table = 'event_posts';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $fillable = [
        // 'title',
        'event_id'
    ];

    /**
     * hasManyTo
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Event\EventComment');
    }

    /**
     * belongsTo
     */
    public function event()
    {
        return $this->belongsTo('App\Models\Event\Event');
    }

    /**
     * @param Builder $query
     * @param $id
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeId(Builder $query, $id)
    {
        return $query->where($this->table . '.id', $id);
    }

    /**
     * @param Builder $query
     * @param $eventId
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeEventId(Builder $query, $eventId)
    {
        return $query->where($this->table . '.event_id', $eventId);
    }
}
