@extends('tourguides.layout')

@section('content')
<div class="card" style="margin: 20px;">
  <div class="card-header">Create New Captain</div>
  <div class="card-body">
       
      <form action="{{ url('/tourguides') }}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}

        <!-- Name -->
        <label>Captain Name</label></br>
        <input type="text" name="captain" id="captain" class="form-control" placeholder="Enter Guide's Name"></br>

        <!-- Phone Number -->
        <label>Phone Number</label></br>
        <input type="text" name="phn_number" id="phn_number" class="form-control" placeholder="Enter Phone Number"></br>

        <!-- Instagram -->
        <label>Instagram Profile Link</label></br>
        <input type="url" name="insta" id="insta" class="form-control" placeholder="Enter Instagram URL"></br>

        <!-- Image -->
        <label>Profile Image</label></br>
        <input class="form-control" name="image" type="file" id="image"></br>

        <!-- Submit Button -->
        <input type="submit" value="Save" class="btn btn-success"></br>
      </form>
   
  </div>
</div>
@stop
