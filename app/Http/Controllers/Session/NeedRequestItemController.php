<?php

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;
use App\Http\Requests\Session\StoreNeedRequestItemRequest;
use App\Models\NeedRequest;
use App\Models\NeedRequestItem;
use Exception;
use Illuminate\Http\Request;

class NeedRequestItemController extends Controller
{
    public function store(StoreNeedRequestItemRequest $request )
    {
        try{
            $request->validated();
            if($request->hasFile('attachment')){
                $file = $request->file('attachment');
                $fileName = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/storage/kapatax/documents/commercial/needRequests/',$fileName);
            } else {
                $fileName = null;
            }
            NeedRequestItem::create([
                'need_request_id'=>$request->need_request_id,
                'reference'=>$request->reference,
                'quantity'=>$request->quantity,
                'unity_id'=>$request->unity_id,
                'status_id'=>$request->status_id,
                'attachment'=>$fileName,
            ]);
            return redirect()->back();
            
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(NeedRequestItem $myNeedRequestItem)
    {
        try{
            $myNeedRequestItem->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    } 

}
