@extends('inclusions.layout')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Manage Package Benefits</h2>
    <p class="text-muted text-center">Tick the benefits you want to include. Unchecked items will be excluded.</p>

    <form action="{{ route('inclusions.manage', ['packageId' => $packageId]) }}" method="POST">
        @csrf

        <div class="row">
            @foreach ($includes as $include)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $include->Name }}</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                    name="inclusions[{{ $include->include_id }}][isActive]" 
                                    value="1" 
                                    id="benefit-{{ $include->include_id }}"
                                    {{ isset($existingInclusions[$include->include_id]) && $existingInclusions[$include->include_id] ? 'checked' : '' }}>
                                <label class="form-check-label" for="benefit-{{ $include->include_id }}">
                                    <strong>Include Benefit</strong>
                                </label>
                                <input type="hidden" name="inclusions[{{ $include->include_id }}][include_id]" value="{{ $include->include_id }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
        </div>
    </form>
</div>
@endsection
