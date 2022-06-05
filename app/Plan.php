<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Plan extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'category',
        'description'
    ];

    protected $appends = ['price', 'sessions'];

    public function getSessionsAttribute()
    {
        return PlanSession::where('plan_id', $this->id)->get();
    }

    public function getPriceAttribute()
    {
        $prices = PlanSession::where('plan_id', $this->id)->pluck('price')->toArray();
        array_unshift($prices);
        if(isset($prices[0]))
            return $prices[0];
        return 0;
    }
}
