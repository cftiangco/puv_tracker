@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Discount Cards Approval</h1>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col">
        <div class="table-responsive">
        <table class="table" id="dt-table">
                <thead>
                    <tr>
                        <th scope="col">Full Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Submitted Date/Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($discounts as $row)
                    <tr>
                      <td>{{$row->last_name}}, {{$row->first_name}} {{$row->middle_name}}</td>
                      <td>{{$row->type}}</td>
                      <td>{{ \Carbon\Carbon::parse($row->created_at)->format('F j, Y h:i:s A') }}</td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <form action="/dashboard/approvals/{{$row->id}}" method="POST" onsubmit="return confirm('Are you sure you want to approve this request?');">
                                @csrf
                                @method("POST")
                                <button type="submit" class="btn btn-sm btn-primary">Approve</button>
                            </form>
                            <a href="/dashboard/approvals/{{$row->id}}" class="btn btn-sm btn-info">View</a>
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
