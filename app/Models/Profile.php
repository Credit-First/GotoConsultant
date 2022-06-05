<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
           /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'profile';

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
        'gender', 'birth', 'street', 'zip_code', 'cover_img', 'avatar', 'skype', 'profession', 'from', 'country', 'region', 'gmt', 'timezone', 'timetable', 'description', 'college'
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
