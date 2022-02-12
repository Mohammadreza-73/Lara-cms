<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theme extends Model
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
        'size',
        'file',
        'images',
        'active',
    ];

    /**
     * Check theme activation status
     *
     * @return boolean
     */
    public function isActive()
    {
        return (bool) $this->active;
    }
}
