@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Driver</h1>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col-12 col-lg-6">
        <form method="POST" action="/dashboard/drivers/{{$driver->id}}">
            @csrf
            @method("PUT")
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $driver->last_name }}" required>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $driver->first_name }}" required>
            </div>

            <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $driver->middle_name }}">
            </div>

            <div class="form-group">
                <label for="birthday">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $driver->birthday }}" required>
            </div>

            <div class="form-group">
                <label for="mobileno">Mobile #</label>
                <input type="text" class="form-control" id="mobileno" name="mobileno" value="{{ $driver->mobileno }}" required>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender1" value="1" {{ $driver->gender == 1 ? 'checked':''}}>
                <label class="form-check-label" for="gender1">
                    Male
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender2" value="2" {{ $driver->gender == 2 ? 'checked':''}}>
                <label class="form-check-label" for="gender2">
                    Female
                </label>
            </div>

            <hr/>

            <div class="form-group">
                <label for="puv_platenumber">PUV Plate #</label>
                <input type="text" class="form-control" id="puv_platenumber" name="puv_platenumber" value="{{ $driver->puv_platenumber }}" required>
            </div>

            <div class="form-group">
                <label for="license_no">License no.</label>
                <input type="text" class="form-control" id="license_no" name="license_no" value="{{ $driver->license_no }}" required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="status_id" class="form-check-input" name="status_id" id="status_id" value="1" {{ $driver->status_id == 1 ? 'checked':''}}>
                <label class="form-check-label" for="status_id">Active/Inactive</label>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <div class="col-6 d-none d-lg-block"></div>
</div>
@stop