<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
           /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

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
        'category_name', 'category_name_no', 'category_url', 'category_description', 'category_description_no', 'vat', 'meta_title', 'meta_description', 'category_icon', 'image_access'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeGetByCategoryName($query, $category_name = null)
    {
        if (empty($category_name)) {
            return $query;
        }
        return $query->where(with(new Categories)->getTable().'.category_name', $category_name);
    }



}
