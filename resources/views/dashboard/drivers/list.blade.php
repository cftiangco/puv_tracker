@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Drivers</h1>
    <a href="/dashboard/drivers/register" class="btn btn-primary">Register Driver</a>
</div>

<?php

    function getAge($birthday) {
        $date = new DateTime($birthday);
        $now = new DateTime();
        $interval = $now->diff($date);
        return $interval->y;
    }

?>

 <!-- Content Row -->
<div class="row">
    <div class="col">
        <div class="table-responsive">
        <table class="table" id="dt-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Age</th>
                        <th scope="col">Mobile #</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Driver's License</th>
                        <th scope="col">Plate #</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $row)
                        <tr>
                            <th scope="row">{{ $row->id }}</th>
                            <td>{{ $row->last_name }}, {{ $row->first_name }} {{ $row->middle_name }}</td>
                            <td>{{ $row->username }}</td>
                            <td>{{ getAge($row->birthday) }}</td>
                            <td>{{ $row->mobileno }}</td>
                            <td>{{ $row->gender == 1 ? 'Male':'Female' }}</td>
                            <td>{{ $row->license_no }}</td>
                            <td>{{ $row->puv_platenumber }}</td>
                            <td>{{ $row->description }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form action="/dashboard/drivers/{{$row->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                    <a href="/dashboard/drivers/{{ $row->id }}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="/dashboard/drivers/{{ $row->id }}/view" class="btn btn-sm btn-primary">View</a>
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