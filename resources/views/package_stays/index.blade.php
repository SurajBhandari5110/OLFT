<!-- resources/views/packages/index.blade.php -->

@foreach ($packages as $package)
    <!-- Existing code for displaying packages -->
    <td>
        <!-- Other actions -->
        <a href="{{ route('package_stays.create', [$package->pk_Package_id, $package->country, $package->state]) }}" class="btn btn-primary btn-sm">Add Stays</a>
    </td>
@endforeach
