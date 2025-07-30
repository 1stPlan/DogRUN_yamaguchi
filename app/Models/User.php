<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'login_count',
        'img_no',
        // 'img_url',
        'intro',
        'google_id',
        'google_email',
        'avatar',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailJapanese);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * hasManyTo
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Event\EvenComment');
    }

    public function event_view()
    {
        return $this->hasMany('App\Models\Event\EventView');
    }

    public function event_participant()
    {
        return $this->hasMany('App\Models\Event\EventParticipant ');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeId(Builder $query, $id)
    {
        return $query->where($this->table.'.id', $id);
    }
}
