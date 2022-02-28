@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admin Accounts</h1>
    <a href="/dashboard/admins/register" class="btn btn-primary">Register Account</a>
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
                        <th scope="col">User Name</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->last_name }}, {{ $row->first_name }} {{ $row->middle_name }}</td>
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->role }}</td>
                            <td>{{ $row->status }}</td>
                            <td>
                                <a href="/dashboard/admins/{{ $row->id }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop