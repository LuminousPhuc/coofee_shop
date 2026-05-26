<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionGroup extends Model
{
    protected $fillable = ['name', 'display_type'];

    public $timestamps = false;

    /**
     * Get the option values for the option group.
     */
    public function optionValues()
    {
        return $this->hasMany(OptionValue::class, 'group_id');
    }

    /**
     * Get the products associated with this option group.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_option_groups', 'group_id', 'product_id');
    }
}
