@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Schedules</h1>
    <a href="/dashboard/schedules/new" class="btn btn-primary">New Schedule</a>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col">
        <div class="table-responsive">
        <table class="table" id="dt-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Departing Time</th>
                        <th scope="col">Fee</th>
                        <th scope="col">No. of Seats</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $row)
                        <tr>
                            <th scope="row">{{ $row->id }}</th>
                            <td>{{ $row->location_from }}</td>
                            <td>{{ $row->location_to }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->departing_time)->format('h:i a') }}</td>
                            <td>P{{ $row->fee }}</td>
                            <td>{{ $row->number_of_seats }}</td>
                            <td>{{ $row->description }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form action="/dashboard/schedules/{{$row->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                    <a href="/dashboard/schedules/{{ $row->id }}" class="btn btn-sm btn-warning">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop