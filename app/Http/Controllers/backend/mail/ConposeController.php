<?php

namespace App\Http\Controllers\backend\mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConposeController extends Controller
{
    //
    public function index()
    {
       return view("backend.mailbox.compose");
    }
}
