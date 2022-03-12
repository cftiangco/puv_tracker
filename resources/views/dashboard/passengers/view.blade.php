@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Passenger: <strong>{{ $passenger->last_name }}, {{ $passenger->first_name }} {{ $passenger->middle_name }} </strong></h1>
</div>
<hr/>
 <!-- Content Row -->
<div class="row">

    <div class="col-12 col-lg-6">
        <ul class="list-group">
            <li class="list-group-item">Birthday: {{ \Carbon\Carbon::parse($passenger->birthday)->format('F j, Y') }}</li>
            <li class="list-group-item">Gender: {{ $passenger->gender == 1 ? 'Male':'Female' }}</li>
            <li class="list-group-item">Mobile no.: {{ $passenger->mobileno }}</li>
            <li class="list-group-item">User Name: {{ $passenger->username }}</li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    Discount Type: {{ $passenger->discount ?? 'N/A' }}
                </div>
                <div>
                    <a href="/dashboard/passengers/{{$passenger->id}}/discounts" class="btn btn-info btn-warning">Edit</a>
                </div>
            </li>
            <li class="list-group-item">Status: {{ $passenger->description }}</li>
        </ul>
    </div>

    <div class="col-12 col-lg-6 d-flex justify-content-between mt-4">
        <h4>Balance: P{{$balance ?? 0}}</h4>
        <div>
            <a href="/dashboard/passengers/{{$passenger->balance_id}}/topup" class="btn btn-info">Top-up</a>
        </div>
    </div>

</div>
@stop