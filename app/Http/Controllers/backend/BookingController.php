<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function index()
    {
        return view("backend.supplier_booking.index");
    }
}
