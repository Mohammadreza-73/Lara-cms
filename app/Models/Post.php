<?php

namespace App\Models;

use AdminUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, AdminUtil;

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
}
