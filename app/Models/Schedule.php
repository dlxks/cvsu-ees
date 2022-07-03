<?php

namespace App\Models;

use App\Http\Traits\HasCan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    use HasCan;

    protected $fillable = [
        'sched_code',
        'sched_name',
        'date',
        'applicant_id',
        'status',
    ];

    protected $appends = [
        'can',
    ];

    public function exams()
    {
        return $this->belongsToMany(Exam::class,'exam_schedules');
        // return $this->hasMany(Exam::class, 'exam_id', 'id');
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
