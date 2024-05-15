<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
    ];


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
