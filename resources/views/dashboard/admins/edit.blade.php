@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Register Account</h1>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col-12 col-lg-6">
        <form method="POST" action="/dashboard/admins/{{$user->id}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{$user->last_name}}" required>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{$user->first_name}}" required>
            </div>

            <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{$user->middle_name}}">
            </div>

            <hr/>

            <div class="form-group">
                <label for="role_id">Role</label>
                    <select class="form-control" id="schedule_id" name="role_id">
                    @foreach($roles as $row)
                        <option value="{{$row->id}}" {{ $row->id === $user->role_id ? 'selected':''}}>{{$row->description}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="status_id" class="form-check-input" name="status_id" id="status_id" value="1" {{$user->status_id == 1 ? 'checked':''}}>
                <label class="form-check-label" for="status_id">Active/Inactive</label>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/dashboard/admins/{{$user->id}}/newpassword" class="btn btn-info">New Passowrd</a>
        </form>
    </div>
    <div class="col-6 d-none d-lg-block"></div>
</div>
@stop