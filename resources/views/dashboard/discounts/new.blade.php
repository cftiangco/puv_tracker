@extends('templates.layout')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">New Discount</h1>
</div>

 <!-- Content Row -->
<div class="row">
    <div class="col-12 col-lg-6">
        <form method="POST" action="/dashboard/discounts/new">
            @csrf
            <div class="form-group">
                <label for="type">Discount Type</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>

            <div class="form-group">
                <label for="discount">Discount %</label>
                <input type="number" class="form-control" id="discount" name="discount" required>
            </div>
            
            <div class="form-check mb-3">
                <input type="checkbox" name="status_id" class="form-check-input" name="status_id" id="status_id" value="1" checked>
                <label class="form-check-label" for="status_id">Active/Inactive</label>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="col-6 d-none d-lg-block"></div>
</div>
@stop