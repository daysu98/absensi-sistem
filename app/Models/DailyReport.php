<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $table = 'daily_reports';
    protected $primaryKey = 'report_id';
    public $timestamps = true;

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
