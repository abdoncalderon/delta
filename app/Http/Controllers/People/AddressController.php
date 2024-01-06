<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\StoreAddressRequest;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(StoreAddressRequest $request) {
        try{
            Address::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Address $address){
        try{
            $address->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function getAddresses(Request $request, $id)
    {
        if($request->ajax())
        {
            $addresses = Address::select('addresses.*')
                ->with('city')
                ->where('person_id',$id)
                ->get();
            return response()->json($addresses);
        }
    }
}
