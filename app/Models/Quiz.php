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
        'published',
        'public',
    ];

    protected $casts = [
        'published' => 'boolean',
        'public' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function scopePublic($q)
    {
        return $q->where('public', true);
    }

    public function scopePublished($q)
    {
        return $q->where('published', true);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function isDoneByUser($user)
    {
        if (!isset($user)) {
            return null;
        }
        $this->tests()->where('user_id', $user->id)->each(function ($test) {

            if (now()->diffInMinutes($test->created_at->addMinutes($this->limited_time)) <= 0) {
                $test->time_spent = $this->limited_time;
                $test->save();
            }
        });
        if ($this->tests()->where('user_id', $user->id)->exists() && $this->tests()->where('user_id', $user->id)->first()->time_spent !== null) {
            return $this->tests()->where('user_id', $user->id)->where('quiz_id', $this->id)->first();
        }
        return null;
    }

    public function needContinue($user)
    {
        if (!isset($user)) {
            return null;
        }
        return $this->tests()->where('user_id', $user->id)->exists() && $this->tests()->where('user_id', $user->id)->first()->time_spent === null;
    }


}
