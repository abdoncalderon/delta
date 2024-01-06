<?php

namespace App\Http\Controllers\Commercial\Purchases;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestNotification;
use App\Models\QuotationRequest;
use App\Models\Stakeholder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use App\Mail\RequestForQuote;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    public function index()
    {
        $stakeholders = Stakeholder::select()
            ->where('project_id',session('current_project_id'))
            ->where('stakeholder_type_id', 4)
            ->get();

        $purchaseRequests = PurchaseRequest::select(DB::raw('purchase_requests.*, (purchase_requests.status_id > 1) as sendFlag'))
            ->with('needRequest.approver.user.person')
            ->with('needRequest.projectUser.user.person')
            ->with('needRequest.location.zone')
            ->with('sorter.user.person')
            ->with('purchaseRequestItems.unity')
            ->with('purchaseRequestNotifications.stakeholder')
            ->join('need_requests','purchase_requests.need_request_id','=','need_requests.id')
            ->join('locations','need_requests.location_id','=','locations.id')
            ->join('location_project_users','locations.id','=','location_project_users.location_id')
            ->where('location_project_users.project_user_id',session('current_project_user')->id)
            ->get();

        return Inertia::render('Commercial/Purchases/PurchaseRequests/Index', [
            'purchaseRequests' => $purchaseRequests,
            'stakeholders' => $stakeholders,
        ]);
    }

    

    public function send ($id){
        try{
            
            $purchaseRequest = PurchaseRequest::find($id);

            /* send notifications to supplier */

            foreach($purchaseRequest->purchaseRequestNotifications as $notification){

                /* verify if notifications was not sent */

                if($notification->status_id == 1){

                    // Mail::to($notification->stakeholder->email)->queue(new RequestForQuote($purchaseRequest));

                    $notification->update([
                        'status_id' => '2',
                    ]);

                    
                    
                    $quotationRequest = QuotationRequest::create([
                        'purchase_request_id'=>$purchaseRequest->id,
                        'stakeholder_id'=>$notification->stakeholder_id,
                        'buyer_id'=>current_user()->id,
                        'sendDate'=> Carbon::now()->toDateString(),
                    ]);
                }
            }

            /** update status purchase request to sent */

            $purchaseRequest->update([
                'status_id' => '2',
            ]);
            
            return redirect()->back();

        }catch(Exception $e){

            return back()->withErrors($e->getMessage());
        }
    }

    public function getPurchaseRequestNotifications(Request $request, $id)
    {
        if($request->ajax())
        {
            $notifications = PurchaseRequestNotification::select('purchase_request_notifications.*')
                ->with('stakeholder')
                ->where('purchase_request_id',$id)
                ->get();
            return response()->json($notifications);
        }
    }
}
