<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;

class TourController extends Controller
{
    public function index()
    {
    $packages = Package::select('pk_Package_id','title', 'duration', 'image')->get();
    return view('index', compact('packages'));
    }
}
