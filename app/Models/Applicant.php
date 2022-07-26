<?php

namespace App\Models;

use App\Http\Traits\HasCan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Notifications\Notifiable;
use App\Models\Schedule;

class Applicant extends Model
{
    use HasFactory;
    use HasCan;
    use Notifiable;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'applicants', 'length' => 10, 'prefix' => date('ym'), 'reset_on_prefix_change' => true]);
        });
    }

    protected $fillable = [
        'user_id',
        'fname',
        'mname',
        'lname',
        'birthday',
        'email',
        'phone_number',
    ];

    protected $appends = [
        'can',
    ];

    public function userAccount()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function result()
    {
        return $this->hasMany(Result::class);
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function attempt(){
        return $this->hasOne(Attempt::class);
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
