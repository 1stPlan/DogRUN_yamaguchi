<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'places';

    protected $fillable = [
        'name',
        'data_id',
        'address',
        'tag',
        'price',
        'time',
        'off',
        'tel',
        'lat',
        'lng',
        'url',
        'service_1',
        'service_2',
        'service_3',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * hasManyTo
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post\Post');
    }

    /*
    * @param Builder $query
    * @param $tag
    * @return \Illuminate\Database\Query\Builder
    */

    public function scopeTag(Builder $query, $tag)
    {
        return $query->where($this->table.'.tag', $tag);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeId(Builder $query, $id)
    {
        return $query->where($this->table.'.id', $id);
    }

    /*
      * @param Builder $query
      * @param $data_id
      * @return \Illuminate\Database\Query\Builder
      */

    public function scopeDataId(Builder $query, $data_id)
    {
        return $query->where($this->table.'.data_id', $data_id);
    }
}
