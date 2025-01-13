<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ClientQuery;
class ClientQueryController extends Controller
{
    // Display all client queries
    public function index()
    {
        $queries = ClientQuery::all();
        return view('client_queries.index', compact('queries'));
    }

    // Show the form to create a new query
    public function create()
    {
        return view('client_queries.create');
    }

    // Store a newly created query in the database
    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'integer|nullable',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'message' => 'required|string',
        ]);

        ClientQuery::create($request->all());
        $queries = ClientQuery::all();
        return response()->json([
            'success' => true,
            
        ]);
    }
    

    // Display a specific query
    public function show($id)
    {
        $query = ClientQuery::findOrFail($id);
        return view('client_queries.show', compact('query'));
        
    }
    public function fetch($id)
    {
        $query = ClientQuery::findOrFail($id);
       
        return response()->json([
            'success' => true,
            'data' => $query,
        ]);
    }
}
