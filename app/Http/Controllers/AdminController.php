<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Attendance;
use App\Models\DailyReport;
use App\Models\Task;
use App\Models\Department;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $internsCount = Intern::count();
        $attendancesCount = Attendance::count();
        $dailyReportsCount = DailyReport::count();
        $tasksCount = Task::count();
        $departmentsCount = Department::count();

        return view('admin.dashboard', compact('internsCount', 'attendancesCount', 'dailyReportsCount', 'tasksCount', 'departmentsCount'));
    }

    public function userManagement()
    {
        $interns = Intern::all();
        $supervisors = Supervisor::all();

        return view('admin.user-management', compact('interns', 'supervisors'));
    }

    public function createIntern()
    {
        $departments = Department::all();
        return view('admin.create-intern', compact('departments'));
    }

    public function storeIntern(Request $request)
    {
        $intern = new Intern;
        $intern->name = $request->name;
        $intern->email = $request->email;
        $intern->phone_number = $request->phone_number;
        $intern->address = $request->address;
        $intern->department_id = $request->department_id;
        $intern->save();

        return redirect()->route('admin.user-management')->with('success', 'Intern created successfully!');
    }

    public function editIntern($internId)
    {
        $intern = Intern::find($internId);
        if (!$intern) {
            return abort(404);
        }
        $departments = Department::all();
        return view('admin.edit-intern', compact('intern', 'departments'));
    }

    public function updateIntern(Request $request, $internId)
    {
        $intern = Intern::find($internId);
        if (!$intern) {
            return abort(404);
        }
        $intern->name = $request->name;
        $intern->email = $request->email;
        $intern->phone_number = $request->phone_number;
        $intern->address = $request->address;
        $intern->department_id = $request->department_id;
        $intern->save();

        return redirect()->route('admin.user-management')->with('success', 'Intern updated successfully!');
    }

    public function createSupervisor()
    {
        $departments = Department::all();
        return view('admin.create-supervisor', compact('departments'));
    }

    public function storeSupervisor(Request $request)
    {
        $supervisor = new Supervisor;
        $supervisor->name = $request->name;
        $supervisor->email = $request->email;
        $supervisor->phone_number = $request->phone_number;
        $supervisor->department_id = $request->department_id;
        $supervisor->save();

        return redirect()->route('admin.user-management')->with('success', 'Supervisor created successfully!');
    }

    public function editSupervisor($supervisorId)
    {
        $supervisor = Supervisor::find($supervisorId);
        if (!$supervisor) {
            return abort(404);
        }
        $departments = Department::all();
        return view('admin.edit-supervisor', compact('supervisor', 'departments'));
    }

    public function updateSupervisor(Request $request, $supervisorId)
    {
        $supervisor = Supervisor::find($supervisorId);
        if (!$supervisor) {
            return abort(404);
        }
        $supervisor->name = $request->name;
        $supervisor->email = $request->email;
        $supervisor->phone_number = $request->phone_number;
        $supervisor->department_id = $request->department_id;
        $supervisor->save();

        return redirect()->route('admin.user-management')->with('success', 'Supervisor updated successfully!');
    }

    public function departments()
    {
        $departments = Department::all();

    }
}
