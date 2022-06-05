<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanSession extends Model
{
    protected $fillable = [
        'plan_id',
        'title',
        'duration',
        'currency_type',
        'price'
    ];
}
