<?php

namespace App;

use Moloquent\Eloquent\Model;

class Task extends Model
{
    protected $collection = 'tasks';

    protected $dates = ['deadline'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requester_id', 'objective', 'description', 'from_where', 'to_where', 'deadline', 'cost', 'tip'
    ];
}