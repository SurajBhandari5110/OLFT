@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Inclusion</h1>

    <form action="{{ route('inclusions.update', $inclusion->inclusion_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="include" class="form-label">Benefit</label>
            <input type="text" class="form-control" value="{{ $inclusion->include->Name ?? 'N/A' }}" readonly>
        </div>

        <div class="form-check">
            <input type="hidden" name="isActive" value="0">
            <input type="checkbox" class="form-check-input" name="isActive" value="1" id="isActive" {{ $inclusion->isActive ? 'checked' : '' }}>
            <label class="form-check-label" for="isActive">Active</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Inclusion</button>
    </form>
</div>
@endsection
