<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event\Event;

class EventView extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'event_id',
        'user_id'
    ];

    /**
     * belongsTo
     */

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
