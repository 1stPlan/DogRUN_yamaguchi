<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Post\Post;
use App\Models\Place;

class Rating extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ratings';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'post_id',
        'rating',
    ];

    /**
     * belongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopePlaceId(Builder $query, $placeId)
    {
        return $query->where($this->table.'.place_id', $placeId);
    }

    /**
     * @param  $placeId
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopePostId(Builder $query, $postId)
    {
        return $query->where($this->table.'.post_id', $postId);
    }
}
