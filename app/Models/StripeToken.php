<?php

namespace App\Models;


use DB;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;

class StripeToken extends Model
{
    protected $table      = 'stripe_tokens';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'token'
    ];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

    public function scopeGetByUserId($query, $user_id= null)
    {
        if (!empty($user_id)) {
            $query->where(with(new StripeToken)->getTable().'.user_id', $user_id);
        }
        return $query;
    }
    
    public function scopeGetByToken($query, $token= null)
    {
        if (!empty($token)) {
            $query->where(with(new StripeToken)->getTable().'.token', $token);
        }
        return $query;
    }

}
