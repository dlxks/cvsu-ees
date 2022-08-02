<?php

namespace App\Models;

use App\Http\Traits\HasCan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Result extends Model
{
    use HasFactory, HasCan, Notifiable;


    protected $fillable = [
        'applicant_id',
        'name',
        'course',
        'exam',
        'score',
        'status',
    ];

    protected $appends = [
        'can',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_result');
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
