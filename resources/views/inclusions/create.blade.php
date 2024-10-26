@extends('inclusions.layout')

@section('content')
<div class="container">
    <h1>Create Inclusions for Package</h1>

    <form action="{{ route('inclusions.store') }}" method="POST">
    @csrf
    <input type="hidden" name="pk_Package_id" value="{{ $packageId }}">

    @foreach($includes as $include)
        <div class="form-group">
            <label>
                <input type="checkbox" name="inclusions[{{ $include->include_id }}][isActive]" value="1">
                {{ $include->Name }}
            </label>
            <input type="hidden" name="inclusions[{{ $include->include_id }}][include_id]" value="{{ $include->include_id }}">
        </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Save Inclusion</button>
</form>

</div>
@endsection
