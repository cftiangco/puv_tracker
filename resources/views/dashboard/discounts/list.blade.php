@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Discounts</h1>
    <a href="/dashboard/discounts/new" class="btn btn-primary">New Discount</a>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col">
        <div class="table-responsive">
        <table class="table" id="dt-table">
                <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cards as $row)
                    <tr>
                        <td>{{ $row->type }}</td>
                        <td>{{ $row->discount }}%</td>
                        <td>{{ $row->description }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <form action="/dashboard/discounts/{{$row->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                <a href="/dashboard/discounts/{{ $row->id }}" class="btn btn-sm btn-warning">Edit</a>
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