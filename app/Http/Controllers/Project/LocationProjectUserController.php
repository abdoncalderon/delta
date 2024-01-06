<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreLocationProjectUserRequest;
use App\Models\Location;
use App\Models\LocationProjectUser;
use App\Models\ProjectUser;
use Exception;
use Illuminate\Http\Request;

class LocationProjectUserController extends Controller
{
    public function store(StoreLocationProjectUserRequest $request) {
        try{
            $request->validated();
            foreach ($request->locations as $location) {
                if ($location['checked']){
                    LocationProjectUser::create([
                        'project_user_id' => $request->project_user_id,
                        'location_id' => $location['value']['id'],
                    ]);
                }   
            }
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id){
        try{
            $locationProjectUser = LocationProjectUser::find($id);
            $locationProjectUser->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function getLocationsProjectUser(Request $request, $id)
    {
        if($request->ajax())
        {
            $locationProjectUsers = LocationProjectUser::select('location_project_users.*','locations.name as name')
                ->join('locations','location_project_users.location_id','=','locations.id')
                ->join('project_users','location_project_users.project_user_id','=','project_users.id')
                ->where('project_users.id', $id)
                ->where('project_users.project_id', session('current_project_id'))
                ->orderBy('name')
                ->get();
            return response()->json($locationProjectUsers);
        }
    }

    public function getLocationsProjectUserByZone(Request $request, $id)
    {
        if($request->ajax())
        {
            $locationProjectUsers = LocationProjectUser::select('locations.id as id','locations.name as name')
                ->with('location')
                ->join('locations','location_project_users.location_id','=','locations.id')
                ->join('project_users','location_project_users.project_user_id','=','project_users.id')
                ->where('project_users.id', session('current_project_user')->id)
                ->where('project_users.project_id', session('current_project_id'))
                ->where('locations.zone_id', $id)
                ->orderBy('name')
                ->get();
            return response()->json($locationProjectUsers);
        }
    }

    public function getAvailableLocations(Request $request, ProjectUser $projectUser) {
        if($request->ajax())
        {
            $myLocations = $projectUser->locationProjectUsers;
            $locations = Location::select('locations.*')
                ->join('zones','locations.zone_id','=','zones.id')
                ->where('zones.project_id',session('current_project_id'))
                ->get();
            $availableLocations = [];
            foreach ($locations as $location){
                $exist = false;
                foreach($myLocations as $myLocation)
                {
                    if($myLocation->location_id==$location->id){
                        $exist = true;
                        break;
                    }
                }
                if (!$exist){
                    array_push($availableLocations, $location);
                }
            }
            return response()->json($availableLocations);
        }
    }
}
