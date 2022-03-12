@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Passengers</h1>
    <a href="/dashboard/passengers/register" class="btn btn-primary">Register Passenger</a>
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
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Mobile #</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Discount Card/ID</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($passengers as $row)
                       <tr>
                            <td>{{$row->id}}</td>
                            <td>{{ $row->last_name }}, {{ $row->first_name }} {{ $row->middle_name }}</td>
                            <td>{{ getAge($row->birthday) }}</td>
                            <td>{{ $row->mobileno }}</td>
                            <td>{{ $row->gender == 1 ? 'Male':'Female' }}</td>
                            <td>{{ $row->discount ?? 'None'}} {{ $row->discount_status_id ? $row->discount_status_id === 1 ? '(Active)':'Inactive':''}}</td>
                            <td>{{ $row->description }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="/dashboard/passengers/{{ $row->id }}/view" class="btn btn-sm btn-primary">View</a>
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
