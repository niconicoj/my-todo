<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'userId', 'status', 'title', 'elapsed', 'active'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function todo(){
        return $this->belongsTo(User::class);
    }
}
