<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees = Employee::select('employees.id','employees.name AS employee_name','groups.name as group_name')
            ->join('groups', 'employees.group_id', '=', 'groups.id')
            ->get();
        ///$employees = Employee::all();
        return view('employees.index',['employees'=>$employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $groups = Group::all();
        return view('employees.create',['groups'=>$groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $employee = Employee::create([
            'name'=>$request->input('name'),
            'group_id'=>$request->input('group_id'),
            'created_by'=>Auth::user()->id
        ]);

        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
        return redirect()->route('employees.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
        $employees = Employee::select('employees.id','employees.name AS employee_name','groups.id AS group_id','groups.name as group_name')
            ->join('groups', 'employees.group_id', '=', 'groups.id')
            ->where('employees.id',$employee->id)
            ->get();

        $groups = Group::all();
        return view('employees.edit',['employees'=>$employees,'groups'=>$groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
        $employees = Employee::where('id',$employee->id)
            ->update([
                'name' => $request->input('name'),
                'group_id'=>$request->input('group_id')
            ]);

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
        $findEmployee = Employee::find($employee->id);
        if ($findEmployee->delete()) {
            return redirect()->route('employees.index');
        }

        return back()->withInput();
    }
}
