<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    protected $table = 'interns';
    protected $primaryKey = 'intern_id';
    public $timestamps = true;

    // Relasi dengan tabel lain
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
