<?php

namespace FederalSt\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FederalSt\Vehicle;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission.customer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Auth::user();
        $vehicles = Vehicle::where('owner', $customer->id)->get();

        return view('customer_profile', ['customer' => $customer, 'vehicles' => $vehicles]);
    }
}
