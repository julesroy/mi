<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriseCommandeCarte extends Model
{
    protected $table = 'carte'; // adapte si ta table a un autre nom
    public $timestamps = false;
    protected $fillable = ['nom', 'prix', 'typePlat']; // adapte selon ta structure
}
