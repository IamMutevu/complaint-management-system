<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role == "patient"){
            return redirect('/dashboard');
        }
        else{
            return redirect('/admin/dashboard'); 
        }
    }

    public function admin_dashboard(){
        return view('backend.admin.home');
    }

    public function patient_dashboard(){
        return view('backend.patient.home');
    }
}
