<?php
namespace App\Http\Controllers;

use App\ContactInfo;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showFooter()
    {
        $contactinfos = ContactInfo::all();
        return view('layouts.footer', compact('contactinfos'));
    }
}