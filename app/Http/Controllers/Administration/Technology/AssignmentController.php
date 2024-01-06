<?php

namespace App\Http\Controllers\Administration\Technology;

use App\Http\Controllers\Controller;
use App\Models\StakeholderPerson;
use App\Models\StakeholderPersonAsset;
use App\Models\Asset;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignmentController extends Controller
{
    public function index() {
        $stakeholderPeople = StakeholderPerson::select('stakeholder_people.*')
            ->with('person')
            ->with('stakeholder')
            ->with('position')
            ->with('department')
            ->join('people','stakeholder_people.person_id','=','people.id')
            ->join('stakeholders','stakeholder_people.stakeholder_id','=','stakeholders.id')
            ->where('stakeholders.project_id', session('current_project_id'))
            ->orderBy('people.fullName')
            ->get();
        return Inertia::render('Administration/Technology/Assignments/Index', [
            'stakeholderPeople' => $stakeholderPeople
        ]);
    }

    public function assets($id) {
        $stakeholderPerson = StakeholderPerson::select('stakeholder_people.id as id','people.fullName as name')
            ->join('people','stakeholder_people.person_id','=','people.id')
            ->join('stakeholders','stakeholder_people.stakeholder_id','=','stakeholders.id')
            ->where('stakeholders.project_id', session('current_project_id'))
            ->where('stakeholder_people.id', $id)
            ->get();
        $assets = Asset::where('status_id',1)->get();
        $projectUsers = ProjectUser::select('project_users.id as id','people.fullName as name')
            ->join('users','project_users.user_id','=','users.id')
            ->join('people','users.person_id','=','people.id')
            ->where('project_users.project_id',session('current_project_id'))
            ->get();
        $stakeholderPersonAssets = StakeholderPersonAsset::select('stakeholder_person_assets.id as id','assets.serialNumber as sn','stakeholder_person_assets.deliveryDate as delivery', 'stakeholder_person_assets.returnDate as return' )
            ->with('stakeholderPerson')
            ->with('asset')
            ->with('deliveryUser')
            ->with('returnUser')
            ->join('assets','stakeholder_person_assets.asset_id','=','assets.id')
            ->join('stakeholder_people','stakeholder_person_assets.stakeholder_person_id','=','stakeholder_people.id')
            ->join('people','stakeholder_people.person_id','=','people.id')
            ->join('stakeholders','stakeholder_people.stakeholder_id','=','stakeholders.id')
            ->orderBy('deliveryDate')
            ->get();
        return Inertia::render('Administration/Technology/Assignments/Assets', [
            'stakeholderPerson' => $stakeholderPerson,
            'stakeholderPersonAssets' => $stakeholderPersonAssets,
            'assets' => $assets,
            'projectUsers' => $projectUsers,
        ]);
    }
}
