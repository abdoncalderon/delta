<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use App\Models\LocationProjectUser;
use App\Models\ProjectUser;
use App\Http\Requests\Production\WorkBook\StoreLocationProjectUserRequest;
use App\Http\Requests\Production\WorkBook\UpdateLocationProjectUserRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class LocationProjectUserController extends Controller
{
    public function index(ProjectUser $projectUser)
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
                array_push($availableLocations,$location);
            }
        }
        $locationProjectUsers = LocationProjectUser::select('location_project_users.*')
            ->with('location')
            ->join('locations','location_project_users.location_id','=','locations.id')
            ->join('project_users','location_project_users.project_user_id','=','project_users.id')
            ->where('project_users.id', $projectUser->id)
            ->where('project_users.project_id', session('current_project_id'))
            ->orderBy('name')
            ->get();
        return Inertia::render('Production/WorkBook/Users/Locations', [
            'locationProjectUsers' => $locationProjectUsers,
            'projectUser' => $projectUser,
            'person' => $projectUser->user->person,
            'availableLocations' => $availableLocations
            
        ]);
    }

    

    public function store(StoreLocationProjectUserRequest $request)
    {
        try{
            $request->validated();
            foreach ($request->locations as $location) {
                if ($location['checked']){
                    LocationProjectUser::create([
                        'project_user_id' => $request->project_user_id,
                        'location_id' => $location['value']['id'],
                        'profile' => $request->profile,
                        'receive_notification' => $request->receive_notification,
                    ]);
                }   
            }
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateLocationProjectUserRequest $request, LocationProjectUser $locationProjectUser){
        try{
            $locationProjectUser->update($request->validated());
            return redirect()->back();
        } catch(Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(LocationProjectUser $locationProjectUser)
    {
        try{
            $locationProjectUser->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    
}
