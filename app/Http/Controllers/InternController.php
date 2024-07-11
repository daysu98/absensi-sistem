<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Attendance;
use App\Models\DailyReport;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternController extends Controller
{
    public function dashboard()
    {
        $intern = Auth::user()->intern;
        $attendanceSummary = $this->getAttendanceSummary($intern->id);
        $tasksSummary = $this->getTasksSummary($intern->id);
        $dailyReportsSummary = $this->getDailyReportsSummary($intern->id);

        return view('intern.dashboard', compact('intern', 'attendanceSummary', 'tasksSummary', 'dailyReportsSummary'));
    }

    public function attendance()
    {
        $intern = Auth::user()->intern;
        $attendances = Attendance::where('intern_id', $intern->id)->get();

        return view('intern.attendance', compact('intern', 'attendances'));
    }

    public function checkIn(Request $request)
    {
        $intern = Auth::user()->intern;
        $attendance = new Attendance;
        $attendance->intern_id = $intern->id;
        $attendance->date = date('Y-m-d');
        $attendance->check_in_time = now();
        $attendance->save();

        return redirect()->route('intern.attendance')->with('success', 'Check-in successful!');
    }

    public function checkOut(Request $request)
    {
        $intern = Auth::user()->intern;
        $attendance = Attendance::where('intern_id', $intern->id)->where('date', date('Y-m-d'))->first();

        if ($attendance) {
            $attendance->check_out_time = now();
            $attendance->save();

            return redirect()->route('intern.attendance')->with('success', 'Check-out successful!');
        } else {
            return redirect()->route('intern.attendance')->with('error', 'You haven\'t checked in yet!');
        }
    }

    public function attendanceHistory()
    {
        $intern = Auth::user()->intern;
        $attendances = Attendance::where('intern_id', $intern->id)->get();

        return view('intern.attendance-history', compact('intern', 'attendances'));
    }

    public function dailyReports()
    {
        $intern = Auth::user()->intern;
        $dailyReports = DailyReport::where('intern_id', $intern->id)->get();

        return view('intern.daily-reports', compact('intern', 'dailyReports'));
    }

    public function createDailyReport()
    {
        $intern = Auth::user()->intern;

        return view('intern.daily-reports-create', compact('intern'));
    }

    public function storeDailyReport(Request $request)
    {
        $intern = Auth::user()->intern;
        $dailyReport = new DailyReport;
        $dailyReport->intern_id = $intern->id;
        $dailyReport->date = date('Y-m-d');
        $dailyReport->tasks_completed = $request->tasks_completed;
        $dailyReport->feedback = $request->feedback;
        $dailyReport->save();

        return redirect()->route('intern.daily-reports')->with('success', 'Daily report submitted!');
    }

    public function showDailyReport($reportId)
    {
        $dailyReport = DailyReport::find($reportId);
        if (!$dailyReport) {
            return abort(404);
        }

        return view('intern.daily-reports-show', compact('dailyReport'));
    }

    public function editDailyReport($reportId)
    {
        $dailyReport = DailyReport::find($reportId);
        if (!$dailyReport) {
            return abort(404);
        }

        return view('intern.daily-reports-edit', compact('dailyReport'));
    }

    public function updateDailyReport(Request $request, $reportId)
    {
        $dailyReport = DailyReport::find($reportId);
        if (!$dailyReport) {
            return abort(404);
        }

        $dailyReport->tasks_completed = $request->tasks_completed;
        $dailyReport->save();

        return redirect()->route('intern.daily-reports')->with('success', 'Daily report updated!');
    }


    // Rest of the InternController functions...

    public function tasks()
    {
        $intern = Auth::user()->intern;
        $tasks = Task::where('intern_id', $intern->id)->get();

        return view('intern.tasks', compact('intern', 'tasks'));
    }

    public function assignedTasks()
    {
        $intern = Auth::user()->intern;
        $tasks = Task::where('intern_id', $intern->id)->where('completed', false)->get();

        return view('intern.tasks-assigned', compact('intern', 'tasks'));
    }

    public function completedTasks()
    {
        $intern = Auth::user()->intern;
        $tasks = Task::where('intern_id', $intern->id)->where('completed', true)->get();

        return view('intern.tasks-completed', compact('intern', 'tasks'));
    }

    public function approachingDeadlineTasks()
    {
        $intern = Auth::user()->intern;
        $tasks = Task::where('intern_id', $intern->id)->where('due_date', '<', now()->addDays(7))->where('completed', false)->get();

        return view('intern.tasks-approaching-deadline', compact('intern', 'tasks'));
    }

    public function profile()
    {
        $intern = Auth::user()->intern;

        return view('intern.profile', compact('intern'));
    }

    public function editProfile()
    {
        $intern = Auth::user()->intern;

        return view('intern.profile-edit', compact('intern'));
    }

    public function updateProfile(Request $request)
    {
        $intern = Auth::user()->intern;
        $intern->name = $request->name;
        $intern->email = $request->email;
        $intern->phone_number = $request->phone_number;
        $intern->address = $request->address;
        $intern->save();

        return redirect()->route('intern.profile')->with('success', 'Profile updated!');
    }

    private function getAttendanceSummary($internId)
    {
        $attendances = Attendance::where('intern_id', $internId)->get();
        $summary = [
            'total_present' => $attendances->count(),
            'average_check_in_time' => $attendances->avg('check_in_time'),
            'average_check_out_time' => $attendances->avg('check_out_time'),
            // Hitung statistik kehadiran lainnya
        ];
        return $summary;
    }

    private function getTasksSummary($internId)
    {
        $tasks = Task::where('intern_id', $internId)->get();
        $summary = [
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('completed', true)->count(),
            'approaching_deadline_tasks' => $tasks->where('due_date', '<', now()->addDays(7))->count(),
            // Hitung statistik tugas lainnya
        ];
        return $summary;
    }

    private function getDailyReportsSummary($internId)
    {
        $reports = DailyReport::where('intern_id', $internId)->get();
        $summary = [
            'total_reports' => $reports->count(),
            // Hitung statistik laporan lainnya
        ];
        return $summary;
    }
}
