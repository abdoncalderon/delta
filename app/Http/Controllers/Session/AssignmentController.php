<?php

namespace App\Http\Controllers\Session;

use App\Http\Controllers\Controller;
use App\Models\StakeholderPerson;
use App\Models\StakeholderPersonAsset;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignmentController extends Controller
{
    public function index(){
        $person = auth()->user()->person;
        $stakeholderPersonAssets = StakeholderPersonAsset::select('stakeholder_person_assets.id as id',
                                                                'assets.serialNumber as sn',
                                                                'stakeholder_person_assets.deliveryDate as delivery',
                                                                'stakeholder_person_assets.returnDate as return' )
            ->with('stakeholderPerson')
            ->with('asset')
            ->with('deliveryUser')
            ->with('returnUser')
            ->join('assets','stakeholder_person_assets.asset_id','=','assets.id')
            ->join('stakeholder_people','stakeholder_person_assets.stakeholder_person_id','=','stakeholder_people.id')
            ->join('people','stakeholder_people.person_id','=','people.id')
            ->join('stakeholders','stakeholder_people.stakeholder_id','=','stakeholders.id')
            ->where('stakeholder_person_assets.stakeholder_person_id',active_stakeholder($person)->id)
            ->orderBy('deliveryDate')
            ->get();
            return Inertia::render('Session/MyAssignments/Index', [
                'stakeholderPerson' => active_stakeholder($person),
                'stakeholderPersonAssets' => $stakeholderPersonAssets,
            ]);
    }

}
