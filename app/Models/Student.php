<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function check($date)
    {
        // dd($this->attendances()->where('date', Carbon::parse($date))->first());
        return $this->attendances()->where('date', Carbon::parse($date))->first();
        
    }
}
