<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'task_id';
    public $timestamps = true;

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
