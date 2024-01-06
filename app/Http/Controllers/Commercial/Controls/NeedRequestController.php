<?php

namespace App\Http\Controllers\Commercial\Controls;

use App\Http\Controllers\Controller;
use App\Models\NeedRequest;
use App\Models\NeedRequestItem;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Unity;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NeedRequestController extends Controller
{
    public function index()
    {
        $needRequests = NeedRequest::select('need_requests.*', 'people.fullName as applicant', 'zones.name as zone' )
            ->with('location.zone')
            ->with('costAccount')
            ->with('approver.user.person')
            ->with('needRequestItems.unity')
            ->join('project_users','need_requests.project_user_id','=','project_users.id')
            ->join('users','project_users.user_id','=','users.id')
            ->join('people','users.person_id','=','people.id')
            ->join('locations','need_requests.location_id','=', 'locations.id')
            ->join('location_project_users','locations.id','=','location_project_users.location_id')
            ->join('zones','locations.zone_id','=','zones.id')
            ->where('location_project_users.project_user_id',session('current_project_user')->id)
            ->where('need_requests.status_id',4)
            ->get();
       
        return Inertia::render('Commercial/Controls/NeedRequests/Index', [
            'needRequests' => $needRequests,
        ]);
        
    }

    public function process(Request $request)
    {
        try{

            /* classify need request items by type */

            foreach ($request->needRequestItems as $item) {
                $needRequestItem = NeedRequestItem::find($item['id']);
                $needRequestItem->update([
                    'status_id'=>'5',
                    'class_id'=>$item['class_id'],
                ]);
            }

            /* select items for purchase */

            $itemsForPurchaseRequest = NeedRequestItem::where('need_request_id',$request->need_request_id)
                ->where('status_id','5')
                ->where('class_id','1')
                ->get();
            
            /* if exist items for purchase */

            if($itemsForPurchaseRequest->count()>0)
            {
                /* create purchase request */

                $purchaseRequest = PurchaseRequest::create([
                    'sorter_id' => session('current_project_user')->id,
                    'need_request_id' => $request->need_request_id,
                    'date' => Carbon::now()->toDateString(),
                ]);

                /* create purchase request items */

                foreach ($itemsForPurchaseRequest as $item){
                    PurchaseRequestItem::create([
                        'purchase_request_id'=>$purchaseRequest->id,
                        'need_request_item_id'=>$item->id,
                        'reference'=>$item->reference,
                        'quantity'=>$item->quantity,
                        'unity_id'=>$item->unity_id,
                        'attchment'=>$item->attachment
                    ]);
                }
            }

            /* update status need request in processed */

            $needRequest = NeedRequest::find($request->need_request_id);
            $needRequest->update([
                'status_id'=>'5',
            ]);

            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage() );
        }
    }
}
