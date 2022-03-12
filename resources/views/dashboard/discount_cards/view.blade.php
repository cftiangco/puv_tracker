@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Discount Card</h1>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col-12 col-lg-6">
        <form method="POST" action="/dashboard/passengers/discounts" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="passenger_id" value="{{$passenger->id}}">
            <div class="form-group">
                <label for="card_id">Select Discount Type</label>
                    <select class="form-control" id="card_id" name="card_id">
                    @foreach($cards as $row)
                        <option value="{{$row->id}}">{{$row->type}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ID #">ID #</label>
                <input type="text" class="form-control" id="idno" name="idno" required>
            </div>

            <div class="form-group">
                <label for="image">Upload Proof of Identification</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="col-12 col-lg-6 mt-3">
        <div class="">
            @if($passenger->image)
                <img src="{{ url('') }}/images/{{$passenger->image}}" style="object-fit: cover;width:90%;height:300px;">
                <div class="mt-3">
                    <form action="/dashboard/passengers/discounts/status" method="POST">
                        @csrf
                        <input type="hidden" name="discount_id" value="{{$passenger->discount_id}}">
                        <input type="hidden" name="discount_status_id" value="{{$passenger->discount_status_id}}">
                        <div class="d-flex">
                            <button type="submit" class="btn btn-{{$passenger->discount_status_id == 1 ? 'danger':'success'}}">Set to {{ $passenger->discount_status_id == 1 ? 'Inactive':'Active'}}</button>
                            <p class="mt-3 ml-3">{{ $passenger->type }} - {{ $passenger->idno }}</p>
                        </div>
                    </form>
                </div>

            @endif
        </div>
    </div>

</div>
@stop
