@extends('layouts.app')

@section('content')
    <h1>Submit a Query</h1>
    <form action="{{ route('client_queries.store') }}" method="POST">
        @csrf
        <label for="package_id">Package ID:</label>
        <input type="number" id="package_id" name="package_id" required>
        
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>
        
        <button type="submit">Submit</button>
    </form>
@endsection
