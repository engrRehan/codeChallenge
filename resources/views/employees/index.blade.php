@extends('layouts.app')

@section('content')
    <div class="container col-md-offset-1 col-md-10 col-lg-offset-1 col-lg-10" style="background-color: white; padding: 5px;">
        <div class="row col-md-10 col-md-10"><b>Employees</b>
        </div>
        <div class="row col-md-2 col-md-2"><a href="/employees/create/" class="btn btn-default btn-sm pull-right">Add New</a>
        </div>
        <div class="row col-md-12 col-md-12">&nbsp;</div>
        <div class="row col-md-12 col-md-12">
            <table id="example" class="table table-striped table-bordered dataTable"  role="grid" aria-describedby="example_info">
                <thead>
                <tr role="row">
                    <th>Name</th>
                    <th>Group</th>
                    <td>Edit</td>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($employees as $employee)
                    <tr role="row">
                        <td><a href="/groups/{{$employee->id}}">{{$employee->employee_name}}</a></td>
                        <td>{{$employee->group_name}}</td>
                        <td><a href="/employees/{{$employee->id}}/edit" class="btn btn-primary btn-sm">Edit</a></td>
                        <td><button onclick="
                                    var result = confirm('Are you sure you wish to delete this project?');
                                    if (result) {
                                    document.getElementById('delete-form{{$employee->id}}').submit();
                                    }" class="btn btn-danger btn-sm">Delete</button></td>
                        <form
                                id="delete-form{{$employee->id}}"
                                action="{{route('employees.destroy',[$employee->id])}}"
                                method="POST"
                                style="display:none;">
                            {{csrf_field()}}
                            {{ method_field('DELETE') }}


                        </form>

                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>

@endsection