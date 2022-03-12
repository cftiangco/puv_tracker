@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Register Driver</h1>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col-12 col-lg-6">
        <form method="POST" action="/dashboard/drivers/register">
            @csrf
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>

            <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name">
            </div>

            <div class="form-group">
                <label for="birthday">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>

            <div class="form-group">
                <label for="mobileno">Mobile #</label>
                <input type="text" class="form-control" id="mobileno" name="mobileno">
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender1" value="1" checked>
                <label class="form-check-label" for="gender1">
                    Male
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender2" value="2">
                <label class="form-check-label" for="gender2">
                    Female
                </label>
            </div>

            <hr/>

            <div class="form-group">
                <label for="puv_platenumber">PUV Plate #</label>
                <input type="text" class="form-control" id="puv_platenumber" name="puv_platenumber" required>
            </div>

            <div class="form-group">
                <label for="license_no">License no.</label>
                <input type="text" class="form-control" id="license_no" name="license_no" required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="status_id" class="form-check-input" name="status_id" id="status_id" value="1" checked>
                <label class="form-check-label" for="status_id">Active/Inactive</label>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="col-6 d-none d-lg-block"></div>
</div>
@stop