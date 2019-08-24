@extends('layouts.app')

@section('content')
    <div class="container" style="background-color: white">
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Add New Group</h4>
            <form method="post" action="{{route('groups.store')}}">
                {{csrf_field()}}
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
                        >
                        <div class="invalid-feedback">
                            Group name is required
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="group">Group</label>
                        <textarea
                            class="form-control"
                            id="group"
                            name="description"
                            rows="3"
                        >
                        </textarea>

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