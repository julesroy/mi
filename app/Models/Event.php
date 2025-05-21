<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'idEvent';
    public $timestamps = false;
    protected $fillable = ['nom', 'date', 'prix'];
}
