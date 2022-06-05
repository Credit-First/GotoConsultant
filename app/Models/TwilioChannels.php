<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwilioChannels extends Model
{
           /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'channels';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'channel', 'consultant_id', 'customer_id', 'direction'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
  
}
