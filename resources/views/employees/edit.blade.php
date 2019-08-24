@extends('layouts.app')

@section('content')
    <div class="container" style="background-color: white">
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Edit Employee</h4>
            <form method="post" action="{{route('employees.update',[$employees[0]->id])}}">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="put">
                <div class="row">
                    <div class="col-md-6">
                        <label for="firstName">Name</label>
                        <input
                                type="text"
                                class="form-control"
                                id="firstName"
                                name="name"
                                placeholder=""
                                required=""
                                value="{{$employees[0]->employee_name}}"

                        >
                        <div class="invalid-feedback">
                            Employee name is required
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="group">Group</label>
                        <select
                                class="form-control"
                                id="group"
                                name="group_id"
                        >
                            <option value="{{$employees[0]->group_id}}">{{$employees[0]->group_name}}</option>
                            @foreach ($groups as $group)
                                <option value="{{$group->id}}">{{$group->name}}</option>
                            @endforeach
                        </select>

                    </div>

                </div>


                <hr class="mb-4">
                <button type="submit" class="btn btn-primary btn-md">SAVE</button>
                <br/>
                <br/>
            </form>
        </div>

    </div>
@endsection