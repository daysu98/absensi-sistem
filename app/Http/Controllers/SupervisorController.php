<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Attendance;
use App\Models\DailyReport;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SupervisorController extends Controller
{
    public function dashboard()
    {
        $supervisor = Auth::user()->supervisor;
        $interns = $supervisor->interns;
        $attendanceSummary = $this->getAttendanceSummary($supervisor->id);
        $tasksSummary = $this->getTasksSummary($supervisor->id);

        return view('supervisor.dashboard', compact('supervisor', 'interns', 'attendanceSummary', 'tasksSummary'));
    }

    public function interns()
    {
        $supervisor = Auth::user()->supervisor;
        $interns = $supervisor->interns;

        return view('supervisor.interns', compact('supervisor', 'interns'));
    }

    public function showIntern($internId)
    {
        $intern = Intern::find($internId);
        if (!$intern) {
            return abort(404);
        }

        return view('supervisor.intern', compact('intern'));
    }

    public function internAttendance($internId)
    {
        $intern = Intern::find($internId);
        if (!$intern) {
            return abort(404);
        }

        $attendances = Attendance::where('intern_id', $intern->id)->get();

        return view('supervisor.intern-attendance', compact('intern', 'attendances'));
    }

    public function internDailyReports($internId)
    {
        $intern = Intern::find($internId);
        if (!$intern) {
            return abort(404);
        }

        $dailyReports = DailyReport::where('intern_id', $intern->id)->get();

        return view('supervisor.intern-daily-reports', compact('intern', 'dailyReports'));
    }

    public function internTasks($internId)
    {
        $intern = Intern::find($internId);
        if (!$intern) {
            return abort(404);
        }

        $tasks = Task::where('intern_id', $intern->id)->get();

        return view('supervisor.intern-tasks', compact('intern', 'tasks'));
    }

    public function assignedTasks()
    {
        $supervisor = Auth::user()->supervisor;
        $tasks = Task::where('supervisor_id', $supervisor->id)->where('completed', false)->get();

        return view('supervisor.tasks-assigned', compact('supervisor', 'tasks'));
    }

    public function completedTasks()
    {
        $supervisor = Auth::user()->supervisor;
        $tasks = Task::where('supervisor_id', $supervisor->id)->where('completed', true)->get();

        return view('supervisor.tasks-completed', compact('supervisor', 'tasks'));
    }

    public function approachingDeadlineTasks()
    {
        $supervisor = Auth::user()->supervisor;
        $tasks = Task::where('supervisor_id', $supervisor->id)->where('due_date', '<', now()->addDays(7))->where('completed', false)->get();

        return view('supervisor.tasks-approaching-deadline', compact('supervisor', 'tasks'));
    }

    private function getAttendanceSummary($supervisorId)
    {
        $supervisor = Auth::user()->supervisor;
        $interns = $supervisor->interns;
        $attendances = Attendance::whereIn('intern_id', $interns->pluck('id'))->get();
        $summary = [
            'total_present' => $attendances->count(),
            // Hitung statistik kehadiran lainnya
        ];
        return $summary;
    }

    private function getTasksSummary($supervisorId)
    {
        $tasks = Task::where('supervisor_id', $supervisorId)->get();
        $summary = [
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('completed', true)->count(),
            'approaching_deadline_tasks' => $tasks->where('due_date', '<', now()->addDays(7))->count(),
            // Hitung statistik tugas lainnya
        ];
        return $summary;
    }
}
