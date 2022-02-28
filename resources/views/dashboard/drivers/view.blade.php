@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Driver: <strong>{{ $driver->last_name }}, {{ $driver->first_name }} {{ $driver->middle_name }} </strong></h1>
</div>
<hr/>
 <!-- Content Row -->
<div class="row">

    <div class="col">
        <ul class="list-group">
            <li class="list-group-item">Birthday: {{ \Carbon\Carbon::parse($driver->birthday)->format('F j, Y') }}</li>
            <li class="list-group-item">Gender: {{ $driver->gender == 1 ? 'Male':'Female' }}</li>
            <li class="list-group-item">Mobile no.: {{ $driver->mobileno }}</li>
            <li class="list-group-item">License no.: {{ $driver->license_no }}</li>
            <li class="list-group-item">Plate no.: {{ $driver->puv_platenumber }}</li>
            <li class="list-group-item">Status: {{ $driver->description }}</li>
        </ul>
        <a href="/dashboard/drivers/{{$driver->id}}" class="btn btn-warning mt-3">Edit Info</a>
    </div>

    <div class="col">
        <h4>Add Schedule</h4>

        <form action="/dashboard/slots" method="POST">
            @csrf
            <input type="hidden" value="{{$driver->id}}" name="driver_id">
            <div class="form-group">
                <label for="schedule_id">Select Schedule</label>
                    <select class="form-control" id="schedule_id" name="schedule_id">
                    @foreach ($schedules as $row)
                        <option value="{{ $row->id }}"> {{$row->location_from }} - {{ $row->location_to }} ({{ \Carbon\Carbon::parse($row->departing_time)->format('h:i a') }} Departing Time)</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        @if (count($slots) > 0)
        <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th scope="col">Schedule</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($slots as $row)
                        <tr>
                                <td>{{$row->location_from }} - {{ $row->location_to }} ({{ \Carbon\Carbon::parse($row->departing_time)->format('h:i a') }} Departing Time)</td>
                                <td>
                                    <form action="/dashboard/slots/{{$row->slot_id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                        </tr>
                    @endforeach
                </tbody>
        </table>
        @else
            <h6 class="text-center mt-5">No available schedule(s).</h6x>
        @endif
    </div>

</div>
@stop