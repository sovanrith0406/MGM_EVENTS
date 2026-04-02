<?php

namespace App\Http\Controllers\backend\mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Read_MailController extends Controller
{
    //
    public function index()
    {
       return view("backend.mailbox.read_mail");
    }
}
