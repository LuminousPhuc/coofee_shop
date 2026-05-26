<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $fillable = ['group_id', 'name', 'price_adjustment', 'is_default'];

    public $timestamps = false;

    /**
     * Get the option group that owns the option value.
     */
    public function optionGroup()
    {
        return $this->belongsTo(OptionGroup::class, 'group_id');
    }
}
