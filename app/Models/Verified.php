<?php

namespace App\Models;

use App\Http\Traits\HasCan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Verified extends Model
{
    use HasFactory, HasCan, Notifiable;

    protected $fillable = [
        'applicant_id',
        'name',
        'rating',
        'course_applied',
        'status'
    ];

    protected $appends = [
        'can',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function course()
    {
        return $this->hasOne(Course::class, 'course_name', 'course_applied');
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return now()->parse($value)->timezone(config('app.timezone'))->format('d F Y, H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return now()->parse($value)->timezone(config('app.timezone'))->format('d F Y, H:i:s');
    }
}
