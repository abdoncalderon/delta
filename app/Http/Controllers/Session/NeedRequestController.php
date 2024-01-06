<?php

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\Session\StoreNeedRequestRequest;
use App\Http\Requests\Session\UpdateNeedRequestRequest;
use App\Models\CostAccount;
use App\Models\NeedRequest;
use App\Models\NeedRequestItem;
use App\Models\StakeholderPerson;
use App\Models\Unity;
use App\Models\Zone;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestForApprovalReceived;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\DB;

class NeedRequestController extends Controller
{
    public function index()
    {
        $zones = Zone::where('project_id',session('current_project_id'))->get();
        $unities = Unity::get();
        $myNeedRequests = NeedRequest::select(DB::raw('need_requests.*, (need_requests.status_id < 2) as editFlag, (need_requests.status_id >= 2) as noEditFlag'))
            ->with('location.zone')
            ->with('costAccount')
            ->with('approver.user.person')
           
            ->where('project_user_id',session('current_project_user')->id)
            ->get();
        $cost_accounts = CostAccount::get();
        $projectUser = ProjectUser::find(session('current_project_user')->id);
        $approvers = ProjectUser::select('project_users.id as id','people.fullName as fullName')
            ->join('users','project_users.user_id','=','users.id')
            ->join('people','users.person_id','=','people.id')
            ->join('stakeholder_people','people.id','=','stakeholder_people.id')
            ->where('stakeholder_people.isApprover',1)
            ->where('stakeholder_people.isActive',1)
            ->where('stakeholder_people.person_id','!=',$projectUser->user->person->id)
            ->where('project_users.project_id',session('current_project_id'))
            ->get();
        
        return Inertia::render('Session/MyNeedRequests/Index', [
            'myNeedRequests' => $myNeedRequests,
            'zones' => $zones,
            'approvers' => $approvers,
            'cost_accounts' => $cost_accounts,
            'unities' => $unities, 
        ]);
        
    }

    public function edit(NeedRequest $needRequest) 
    {
        $unities = Unity::get();
        $myNeedRequest = NeedRequest::select('need_requests.*')
            
            ->with('location')
            ->with('needRequestItems')
            ->where('project_user_id', session('current_project_user')->id)
            ->where('id',$needRequest->id)
            ->get();
        return Inertia::render('Session/MyNeedRequests/Edit', [
            'myNeedRequest' => $myNeedRequest,
            'unities' => $unities, 
        ]);
    }

    public function store(StoreNeedRequestRequest $request )
    {
        try{
            $needRequest = NeedRequest::create($request->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateNeedRequestRequest $request, NeedRequest $myNeedRequest )
    {
        try{
            $myNeedRequest->update($request->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function send(UpdateNeedRequestRequest $request, NeedRequest $myNeedRequest )
    {
        try{
            $myNeedRequest->update($request->validated());
            update_need_request_items_status($myNeedRequest, 2);
            Mail::to('abdonc@gmail.com')->queue(new RequestForApprovalReceived($myNeedRequest));
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    } 

    public function destroy(NeedRequest $myNeedRequest)
    {
        try{
            $myNeedRequest->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    } 

    public function getNeedRequestItems(Request $request, $id)
    {
        if($request->ajax())
        {
            $items = NeedRequestItem::select(DB::raw('need_request_items.*, (need_request_items.status_id >= 2) as deleteFlag'))
                ->with('unity')
                ->where('need_request_id',$id)
                ->get();
            return response()->json($items);
        }
    }

    
    


}
