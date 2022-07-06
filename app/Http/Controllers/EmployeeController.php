<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $employee = Employee::latest()->get();
        return view('employee.index', compact('employee'));
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required|max:100',
            'employee_name' => 'required'
        ]);

        $employee  = Employee::create([
            'nik' => $request->nik,
            'employee_name' => $request->employee_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address
        ]);

        if ($employee) {
            return redirect()
                ->route('employee.index')
                ->with([
                    'success' => 'New Employee has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occured, please try again'
                ]);
        }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nik' => 'required|max:100',
            'employee_name' => 'required',
            
        ]);

        $employee = Employee::findOrFail($id);

        $employee->update([
            'nik' => $request->nik,
            'employee_name' => $request->employee_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address
        ]);

        if ($employee) {
            return redirect()
                ->route('employee.index')
                ->with([
                    'success' => 'Employee has been updated successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem has occured, please try again'
                ]);
        }
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        if ($employee) {
            return redirect()
                ->route('employee.index')
                ->with([
                    'success' => 'Employee has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('employee.index')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
