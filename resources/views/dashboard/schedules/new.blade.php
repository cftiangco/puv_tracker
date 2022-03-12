@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">New Schedule</h1>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col-12 col-lg-6">
        <form method="POST" action="/dashboard/schedules/new">
            @csrf
            <div class="form-group">
                <label for="location_from">Location From</label>
                <input type="text" class="form-control" id="location_from" name="location_from" required>
            </div>

            <div class="form-group">
                <label for="location_to">Location To</label>
                <input type="text" class="form-control" id="location_from" name="location_to" required>
            </div>

            <div class="form-group">
                <label for="departing_time">Departing Time</label>
                <input type="time" class="form-control" id="departing_time" name="departing_time" required>
            </div>

            <div class="form-group">
                <label for="fee">Fee</label>
                <input type="number" class="form-control" id="fee" name="fee" required>
            </div>

            <div class="form-group">
                <label for="number_of_seats">No. of Sets</label>
                <input type="number" class="form-control" id="number_of_seats" name="number_of_seats" required>
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