<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\DailyReport;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function index($internId)
    {
        $intern = Intern::find($internId);
        if (!$intern) {
            return abort(404);
        }

    }
}
