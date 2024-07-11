<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $department = new Department;
        $department->name = $request->name;
        $department->description = $request->description;
        $department->save();

        return redirect()->route('departments.index')->with('success', 'Department created successfully!');
    }

    public function edit($departmentId)
    {
        $department = Department::find($departmentId);
        if (!$department) {
            return abort(404);
        }

        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $departmentId)
    {
        $department = Department::find($departmentId);
        if (!$department) {
            return abort(404);
        }

        $department->name = $request->name;
        $department->description = $request->description;
        $department->save();

        return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
    }

    public function destroy($departmentId)
    {
        $department = Department::find($departmentId);
        if (!$department) {
            return abort(404);
        }

        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully!');
    }
}
