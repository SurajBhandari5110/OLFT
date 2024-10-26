@extends('packages.layout')
@section('content')
<div class="card" style="margin: 20px;">
  <div class="card-header">Create New Package</div>
  <div class="card-body">
       
      <form action="{{ url('packages') }}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <label>Title</label></br>
        <input type="text" name="title" id="title" class="form-control"></br>
        <label>About Place</label></br>
        <input type="text" name="about" id="about" class="form-control"></br>
        <label>Destination Loaction</label></br>
        <input type="text" name="location" id="location" class="form-control"></br>
        <label>Duration</label></br>
        <input type="number" name="duration" id="duration" class="form-control"></br>
        <label>Tour-type</label></br>
        <input type="text" name="tour_type" id="tour_type" class="form-control"></br>
        <label>Image</label></br>
        <input class="form-control" name="image" type="file" id="image">
        </br>
        <label>Group Size</label></br>
        <input type="number" name="tour_type" id="group_size" class="group_size">
        </br>
        <label>Tour Guide</label></br>
        <input type="number" name="tour_guide" id="tour_guide" class="group_size"> </br>
        <label>Travel With Bus</label></br>
        <input type="text" name="travel_with_bus" id="travel_with_bus" class="form-control"></br>
        <input type="submit" value="Save" class="btn btn-success"></br>
    </form>
   
  </div>
</div>
@stop