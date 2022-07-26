<?php

namespace App\Models;

use App\Http\Traits\HasCan;
use App\Http\Traits\HasImgUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Question extends Model
{
    use HasFactory;
    use HasCan;
    use HasImgUrl;

    protected $fillable = [
        'exam_id',
        'question',
        'img_path'
    ];

    protected $appends = [
        'can',
        'img_url',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    public function getQuestions()
    {
        return Question::orderBy('created_at', 'asc')->with('exam');
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
