@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Passenger: <strong>{{ $discount->last_name }}, {{ $discount->first_name }} {{ $discount->middle_name }} </strong></h1>
</div>
<hr/>
 <!-- Content Row -->
<div class="row">

    <div class="col-12 col-lg-6">
        <ul class="list-group">
            <li class="list-group-item">Birthday: {{ \Carbon\Carbon::parse($discount->birthday)->format('F j, Y') }}</li>
            <li class="list-group-item">Gender: {{ $discount->gender == 1 ? 'Male':'Female' }}</li>
            <li class="list-group-item">Mobile no.: {{ $discount->mobileno }}</li>
            <li class="list-group-item">User Name: {{ $discount->username }}</li>
        </ul>
        <div class="mt-3">
          <form action="/dashboard/approvals/{{$discount->id}}" method="POST" onsubmit="return confirm('Are you sure you want to approve this request?');">
              @csrf
              @method("POST")
              <button type="submit" class="btn btn-sm btn-primary">Approve Request</button>
          </form>
        </div>
    </div>

    <div class="col-12 col-lg-6 d-flex justify-content-between mt-4">
      <div class="">
          @if($discount->image)
          <p>ID #: {{$discount->idno}}</p>
          <a href="{{ url('') }}/images/{{$discount->image}}" target="_blank">
              <img src="{{ url('') }}/images/{{$discount->image}}" style="object-fit: cover;width:90%;height:300px;">
          </a>
          @endif
      </div>
    </div>

</div>
@stop
