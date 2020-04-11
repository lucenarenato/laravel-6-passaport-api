<?php

namespace FederalSt;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plate', 'renavam', 'brand', 'model', 'color', 'year', 'owner'
    ];
}