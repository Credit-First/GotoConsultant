<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Transactions extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

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
      'receiver_id', 'payer_id', 'amount', 'vat_amount', 'total_amount', 'transaction_id', 'time_spent', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
    ];

    private static $statusLabelValueArray = ['U' => 'Not paid', 'P' => 'Paid', 'I' => 'In invoice'];
// enum('U','P','I')
    public static function getStatusLabelValueArray($key_return = true): array
    {
        if(!$key_return) {
            return self::$statusLabelValueArray;
        }
        $resArray = [];
        foreach (self::$statusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            }
        }
        return $resArray;
    }
    public static function getStatusLabel(string $status): string
    {
        if ( ! empty(self::$statusLabelValueArray[$status])) {
            return self::$statusLabelValueArray[$status];
        }
        return self::$statusLabelValueArray[0];
    }


    public function scopeGetByPayerId($query, $payer_id = null)
    {
        if (empty($payer_id) or $payer_id == 'All') {
            return $query;
        }
        return $query->where(with(new Transactions)->getTable().'.payer_id', $payer_id);
    }

    public function scopeGetByReceiverId($query, $receiver_id = null)
    {
        if (empty($receiver_id) or $receiver_id == 'All') {
            return $query;
        }
        return $query->where(with(new Transactions)->getTable().'.receiver_id', $receiver_id);
    }
    public function scopeGetByStatus($query, $status = null)
    {
        if (empty($status) or $status == 'All') {
            return $query;
        }
        return $query->where(with(new Transactions)->getTable().'.status', $status);
    }


}
