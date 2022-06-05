<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'consultant_id',
        'plan_id',
        'session_id',
        'booking_date',
        'communication_type'
    ];

    protected $appends = ["title", "description"];

    public function getTitleAttribute()
    {
        $session = PlanSession::find($this->session_id);
        return $session->duration . " min " . $session->title;
    }

    public function getDescriptionAttribute()
    {
        $plan = Plan::find($this->session_id);
        return $plan->title . " in " . $plan->category;
    }
}
