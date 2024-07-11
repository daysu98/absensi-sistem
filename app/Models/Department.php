<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'department_id';
    public $timestamps = true;

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }
}
