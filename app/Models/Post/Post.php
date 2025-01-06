<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'tittle',
        'body',
        'place_id',
        'name',
        'ip_address',
        'user_id',
    ];

    /**
     * hasManyTo
     */
    public function ratings()
    {
        return $this->hasMany('App\Models\Post\Rating');
    }

    /**
     * hasManyTo
     */
    public function likes()
    {
        return $this->hasMany('App\Models\Post\Like');
    }

    /**
     * belongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post\Post');
    }

    /**
     * belongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopePlaceId(Builder $query, $placeId)
    {
        return $query->where($this->table.'.place_id', $placeId);
    }
}
