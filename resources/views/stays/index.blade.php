@extends('voyager::master')

@section('content')
    <div class="container">
        <h1>All Stays</h1>
        <a href="{{ route('stays.create') }}" class="btn btn-primary">Add New Stay</a>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stays as $stay)
                    <tr>
                        <td>{{ $stay->name }}</td>
                        <td>
                            {{ Str::limit($stay->description, 100) }}
                            @if (strlen($stay->description) > 100)
                                <a href="#" class="read-more-btn" data-toggle="modal" data-target="#stayModal{{ $stay->pk_hotel_id }}">Read More</a>
                            @endif
                        </td>
                        <td>{{ $stay->country }}</td>
                        <td>{{ $stay->state }}</td>
                        <td><img src="{{ $stay->image }}" alt="{{ $stay->name }}" width="200"></td>
                        <td>
                            <a href="{{ route('stays.edit', $stay->pk_hotel_id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('stays.destroy', $stay->pk_hotel_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this stay?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal for displaying full description -->
                    <div class="modal fade" id="stayModal{{ $stay->pk_hotel_id }}" tabindex="-1" role="dialog" aria-labelledby="stayModalLabel{{ $stay->pk_hotel_id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="stayModalLabel{{ $stay->pk_hotel_id }}">{{ $stay->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{ $stay->description }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <!-- Include Bootstrap JavaScript if not already included -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
