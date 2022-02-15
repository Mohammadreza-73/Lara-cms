<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    /**
     * Morphed by many models
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'catable');
    }

    /**
     * Each Category could has many subcategory
     * 
     * Related to self model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
