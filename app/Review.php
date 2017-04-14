<?php

namespace App;

use Moloquent\Eloquent\Model;

class Review extends Model
{
    protected $collection = 'reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'rating', 'reviewer_id', 'reviewee_id', 'task_id'
    ];
}