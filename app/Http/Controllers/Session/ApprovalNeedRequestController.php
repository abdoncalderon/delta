<?php

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\Session\UpdateApprovalNeedRequestRequest;
use App\Models\NeedRequest;
use Inertia\Inertia;
use Exception;

class ApprovalNeedRequestController extends Controller
{
    public function index()
    {
        $myApprovals = NeedRequest::select('need_requests.*')
            ->with('location.zone')
            ->with('costAccount')
            ->with('approver.user.person')
            ->with('projectUser.user.person')
            ->with('needRequestItems')
            ->where('approver_id', session('current_project_user')->id)
            ->where('status_id', 2)
            ->get();
        return Inertia::render('Session/MyApprovals/Index', [
            'myApprovals' => $myApprovals,
        ]);
        
    }

    public function approve(UpdateApprovalNeedRequestRequest $request, NeedRequest $needRequest){
        try{
            $needRequest->update([
                'status_id'=> $request->status_id
            ]);
            foreach($needRequest->needRequestItems as $needRequestItem){
                $needRequestItem->update([
                    'status_id'=> $request->status_id,
                ]);
            }
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function approveMail(NeedRequest $needRequest, $status){
        try{
            $needRequest->update([
                'status_id'=> $status
            ]);
            foreach($needRequest->needRequestItems as $needRequestItem){
                $needRequestItem->update([
                    'status_id'=> $status
                ]);
            }
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }
    
}
