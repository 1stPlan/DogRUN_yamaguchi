<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactForm extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_top',
        'name_bottom',
        'mail',
        'content',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
