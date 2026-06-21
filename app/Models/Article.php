<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'created', 'text', 'event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
