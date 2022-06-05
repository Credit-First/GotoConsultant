<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissedNotification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'missed_notifications';

    public $timestamps = false;
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
        'sender_id', 'receiver_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at',
    ];

    public function scopeGetBySenderId($query, $sender_id = null)
    {
        if (empty($sender_id)) {
            return $query;
        }
        return $query->where(with(new MissedNotification)->getTable().'.sender_id', $sender_id);
    }

    public function scopeGetByReceiverId($query, $receiver_id = null)
    {
        if (empty($receiver_id)) {
            return $query;
        }
        return $query->where(with(new MissedNotification)->getTable().'.receiver_id', $receiver_id);
    }



}
