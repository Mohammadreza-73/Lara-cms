<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'body',
        'images',
        'view',
        'approved',
    ];

    /**
     * One to many with post (inverse)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return current post slug
     *
     * @return string
     */
    public function path(): string
    {
        return "/posts/{$this->slug}";
    }

    /**
     * Check post status (approved by admin)
     *
     * @return boolean
     */
    public function isApproved(): bool
    {
        return (bool) $this->approved;
    }

    /**
     * Polymorphic many to many with category
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'catable');
    }
}
