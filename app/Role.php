<?php

namespace App;

use SecTheater\Jarvis\Role\EloquentRole;
class Role extends EloquentRole
{
    protected $guarded = [];
    protected $casts = ['permissions' => 'array'];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function bySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }
}