<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];
    public $observers = [
        'first_name' => 'firstUpper',
        'last_name' => 'firstUpper',
        'location' => 'startsWithUpper',
        'about' => 'startsWithUpper'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}