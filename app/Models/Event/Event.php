<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Event\EventView;


class Event extends Model
{
    use SoftDeletes;

    protected $dates = [
        'date',
        'start_datetime',
        'deleted_at',
    ];

    protected $table = 'events';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'shop',
        'start_datetime',
        'img_url',
        'view_count',
        'ticket_price',
        "venue",
        'body',
        'remarks',
    ];

    /**
     * hasMany
     */
    public function eventSearches()
    {
        return $this->hasMany('App\Models\Event\EventSearch');
    }

    public function eventParticipants()
    {
        return $this->hasMany('App\Models\Event\EventParticipant');
    }

    public function views()
    {
        return $this->hasMany(EventView::class);
    }

    /**
     * void
     * リレーション先も削除する方法
     * https://qiita.com/hinako_n/items/b24dfc4bbf6eb32ef4a8
     */

    public static function booted(): void
    {
        static::deleted(function ($events) {
            $events->eventParticipants()->delete();
        });
    }


    /**
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->ticket_price + $this->tax;
    }

    // /**
    //  * @param Builder $query
    //  * @param $userId
    //  * @return \Illuminate\Database\Query\Builder
    //  */
    // public function scopeUserId(Builder $query, $userId)
    // {
    //     return $query->where($this->table . '.user_id', $userId);
    // }

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
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeNotFinished(Builder $query)
    {
        $now = Carbon::now();
        return $query->where($this->table . '.close_datetime', '>', $now->format('Y-m-d H:i:s'));
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeFinished(Builder $query)
    {
        $now = Carbon::now();
        return $query->where($this->table . '.close_datetime', '<=', $now->format('Y-m-d H:i:s'));
    }

    /**
     * @param Builder $query
     * @param $fromDateTime
     * @param $toDateTime
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeStartedBetween(Builder $query, Carbon $fromDateTime, Carbon $toDateTime)
    {
        return $query->whereBetween($this->table . '.start_datetime', [$fromDateTime->format('Y-m-d H:i:s'), $toDateTime->format('Y-m-d H:i:s')]);
    }

    /**
     * @param Builder $query
     * @param $fromDateTime
     * @param $toDateTime
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeFinishedBetween(Builder $query, Carbon $fromDateTime, Carbon $toDateTime)
    {
        return $query->whereBetween($this->table . '.close_datetime', [$fromDateTime->format('Y-m-d H:i:s'), $toDateTime->format('Y-m-d H:i:s')]);
    }

    /**
     * @param Builder $query
     * @param $categoryId
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeCategoryId(Builder $query, $categoryId)
    {
        // NOTE: joinを入れた場合、結合先の論理削除は効かないので、明示する必要あり。
        return $query->join('event_searches', 'events.id', '=', 'event_searches.event_id')
            ->where('event_searches.category_id',  $categoryId)
            ->whereNull('event_searches.deleted_at');
    }


    /**
     * @param Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeIsPublished(Builder $query)
    {
        $now = Carbon::now();
        return $query->where($this->table . '.publish_datetime', '<=', $now->format('Y-m-d H:i:s'));
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeNotFree(Builder $query)
    {
        return $query->where($this->table . '.free_flg', 0);
    }
}
