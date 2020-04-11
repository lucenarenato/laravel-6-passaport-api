<?php

namespace FederalSt\Http\Controllers;

use Illuminate\Http\Request;
use FederalSt\Http\Requests\StoreVehicle;
use FederalSt\Http\Requests\UpdateVehicle;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use FederalSt\Events\VehicleLog;
use FederalSt\User;
use FederalSt\Vehicle;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission.admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = User::customers();
        return view('customer_list',['customers'=>$customers]);
    }

    public function customer($id)
    {
        $customer  = User::where('role', User::ROLE_USER)->where('id',$id)->first();
        $vehicles  = Vehicle::where('owner',$customer->id)->get();

        return view('customer_profile', ['customer' => $customer, 'vehicles' => $vehicles]);
    }


    public function add(StoreVehicle $request)
    {
        try {
            $vehicle = Vehicle::create($request->all());

            $action = trans('core.added');
            $admin = Auth::user();
            $customer = User::find($request->input('owner'));

            event(new VehicleLog($action, $admin, $customer, $vehicle));

            return Response::json(['status' => true, 'messages' => trans('core.save_success'), 'vehicle' => $vehicle->toJson()],200);
        } catch (\Exception $exception) {
            Log::error("AdminController@add: " . $exception->getMessage());
            return Response::json(['status' => false, 'messages' => trans('core.save_fail')],200);
        }
    }

    public function update(UpdateVehicle $request)
    {
        try {
            $data = (object) $request->all();
            $vehicle = Vehicle::where('id', $data->id)->first();

            $vehicle->plate = $data->plate;
            $vehicle->renavam = $data->renavam;
            $vehicle->brand = $data->brand;
            $vehicle->model = $data->model;
            $vehicle->color = $data->color;
            $vehicle->year = $data->year;

            if($vehicle->save()){
                $action = trans('core.updated');
                $admin = Auth::user();
                $customer = User::find($vehicle->owner);

                event(new VehicleLog($action, $admin, $customer, $vehicle));

                return Response::json(['status' => true, 'messages' => trans('core.save_success')],200);
            }
            else
                return Response::json(['status' => false, 'messages' => trans('core.save_fail')],200);

        } catch (\Exception $exception) {
            Log::error("AdminController@update: " . $exception->getMessage());
            return Response::json(['status' => false, 'messages' => trans('core.save_fail')],200);
        }
    }

    public function remove(Request $request)
    {
        try {
            $vehicle_id = $request->input('vehicle_id');
            $vehicle = Vehicle::where('id',$vehicle_id)->first();

            if($vehicle->delete()){
                $action = trans('core.deleted');
                $admin = Auth::user();
                $customer = User::find($vehicle->owner);

                event(new VehicleLog($action, $admin, $customer, $vehicle));
                return Response::json(['status' => true, 'messages' => trans('core.remove_success')],200);
            }
            else
                return Response::json(['status' => false, 'messages' => trans('core.remove_fail')],200);
        } catch (\Exception $exception) {
            Log::error("AdminController@remove: " . $exception->getMessage());
            return Response::json(['status' => false, 'messages' => trans('core.remove_fail')],200);
        }
    }
}
