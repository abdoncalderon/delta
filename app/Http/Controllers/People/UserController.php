<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Models\Clock;
use App\Models\Stakeholder;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Rats\Zkteco\Lib\ZKTeco;

class UserController extends Controller
{
    public function index() {
        $stakeholders = Stakeholder::select('stakeholders.*')
            ->where('project_id', session('current_project_id'))
            ->orderBy('name')
            ->get();
        $clocks = Clock::with('project')    
            ->where('project_id', session('current_project_id'))
            ->orderBy('name')
            ->get();
        return Inertia::render('People/TimeSheet/Users/Index', [
            'clocks' => $clocks,
            'stakeholders' => $stakeholders
        ]);
    }

    public function upload(Request $request) {
        try {
            foreach ($request->clocks as $clock) {
                if ($clock['checked']){
                    foreach ($request->users as $user) {
                        if ($user['checked']){
                            $zkClock = new ZKTeco($clock['value']['ipAddress'], $clock['value']['port']);
                            if ($zkClock->connect()) {
                                $zkClock->disableDevice();
                                $id = intval($user['value']['id']);
                                $uid = $user['value']['id'];
                                $name = substr($user['value']['name'], 0, 24);
                                $cardNo = intval($user['value']['cardNo']);
                                $result = $zkClock->setUser($id, $uid, $name, '', 0, $cardNo);
                                $zkClock->enableDevice();
                            } 
                        }
                    }
                }
            }
            return redirect()->back();
        } catch(Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
