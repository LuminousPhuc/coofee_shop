<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'base_price',
        'image_url',
        'allow_topping',
        'is_active',
        'is_bestseller'
    ];

    public $timestamps = false;

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the option groups associated with the product.
     */
    public function optionGroups()
    {
        return $this->belongsToMany(OptionGroup::class, 'product_option_groups', 'product_id', 'group_id');
    }
}
