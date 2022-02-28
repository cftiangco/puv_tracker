@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Top Up</h1>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col-12 col-lg-6">
        <form method="POST" action="/dashboard/passengers/topup">
            @csrf
            <input type="hidden" name="balance_id" value="{{ $id }}">
            <div class="form-group">
                <label for="discount">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount..." required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="col-6 d-none d-lg-block"></div>
</div>
@stop