<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    use SoftDeletes;

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    protected $table = 'event_participants';

    protected $fillable = [
        'event_id',
        'user_id',
    ];

    protected $primaryKey = 'id';


    /**
     * belongsTo
     */
    public function event()
    {
        return $this->belongsTo('App\Models\Event\Event');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
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
     * @param $userId
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeUserId(Builder $query, $userId)
    {
        return $query->where($this->table . '.user_id', $userId);
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
