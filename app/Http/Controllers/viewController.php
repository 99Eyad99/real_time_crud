<?php

namespace App\Http\Controllers;
use App\Models\post;

use Illuminate\Http\Request;


class viewController extends Controller
{
    public function viewProfile(){
        return view('rendering/profile');
    }

    public function viewDashboard(){
        return view('rendering/dashboard');
    }

    public function viewAccounts(){
        return view('rendering/accounts');
    }

    public function viewCalendar(){
        return view('rendering/calendar');
    }

    public function viewAddpost(){
       // return view('rendering/add-post')->with(['posts' => post::all()]);
       return view('rendering/add-post');
    }


    

    

}
