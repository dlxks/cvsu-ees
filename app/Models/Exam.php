<?php

namespace App\Models;

use App\Http\Traits\HasCan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    use HasCan;

    protected $fillable = [
        'subject',
        'exam_code',
        'description',
        'duration',
        'status',
    ];

    protected $appends = [
        'can',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'exam_id', 'id');
    }

    public function hasExamAttempted()
    {
        $attemptedExam = [];
        $authApplicant = auth()->user()->id;
        $applicant = Answer::where('applicant_id', $authApplicant)->get();
        foreach($applicant as $appl){
            array_push($attemptedExam, $appl->exam_id);
        }

        return $attemptedExam;
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
