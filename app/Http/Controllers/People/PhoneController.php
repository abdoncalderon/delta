<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\StorePhoneRequest;
use App\Models\Phone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhoneController extends Controller
{
    public function store(StorePhoneRequest $request) {
        try{
            Phone::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Phone $phone){
        try{
            $phone->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function getPhones(Request $request, $id)
    {
        if($request->ajax())
        {
            $phones = Phone::select(DB::raw("phones.id as id, phones.country_id as country_id, phones.number as number, CONCAT(countries.name, ' - (', countries.ccc, ')') as country"))
                ->join('countries','phones.country_id','=','countries.id')
                ->where('person_id',$id)->get();
            return response()->json($phones);
        }
    }
}
