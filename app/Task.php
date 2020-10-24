<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'image',
        'checked',
        'description',
        'started_date',
        'category',
        'booked_status',
    ];
}
