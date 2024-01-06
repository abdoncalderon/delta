<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\StoreClockRequest;
use App\Http\Requests\People\UpdateClockRequest;
use App\Models\Clock;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Rats\Zkteco\Lib\ZKTeco;
use Laradevsbd\Zkteco\Http\Library\ZKLib;
use Carbon\Carbon;

class ClockController extends Controller
{
    public function index() {
        $clocks = Clock::with('project')
            ->where('project_id', session('current_project_id'))
            ->orderBy('name')
            ->get();
        return Inertia::render('People/TimeSheet/Clocks/Index', [
            'clocks' => $clocks,
        ]);
    }

    public function store(StoreClockRequest $request) {
        try{
            Clock::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateClockRequest $request, Clock $clock) {
        try{
            $clock->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Clock $clock){
        try{
            $clock->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function isConnected(Request $request, $ipAddress, $port) {
        if($request->ajax()) {
            $flag = false;
            $clock = new ZKTeco($ipAddress, $port);
            $flag = $clock->connect();
            return $flag;
        } 
    }

    public function getAttendance(Request $request, Clock $clock) {
        if($request->ajax()) {
            $clock = new ZKTeco($clock->ipAddress, $clock->port);
            if ($clock->connect()) {
                $clock->disableDevice();
                $attendance = $clock->getAttendance();
                $clock->enableDevice();
                return $attendance;
            } 
        } 
    }

    public function clearAttendance(Request $request, Clock $clock) {
        if($request->ajax()) {
            $clock = new ZKTeco($clock->ipAddress, $clock->port);
            if ($clock->connect()) {
                $clock->disableDevice();
                $attendance = $clock->clearAttendance();
                $clock->enableDevice();
                return $attendance;
            } 
        } 
    }

    public function getUsers(Request $request, Clock $clock) {
        if($request->ajax()) {
            $clock = new ZKTeco($clock->ipAddress, $clock->port);
            if ($clock->connect()) {
                $clock->disableDevice();
                $users = $clock->getUser();
                $clock->enableDevice();
                return $users;
            } 
        } 
    }

    public function clearUsers(Request $request, Clock $clock) {
        if($request->ajax()) {
            $clock = new ZKTeco($clock->ipAddress, $clock->port);
            if ($clock->connect()) {
                $clock->disableDevice();
                $clearUsers = $clock->clearUsers();
                $clock->enableDevice();
                return $clearUsers;
            } 
        } 
    }

    public function setTime(Request $request, Clock $clock) {
        if($request->ajax()) {
            $clock = new ZKLib($clock->ipAddress, $clock->port);
            if ($clock->connect()) {
                $clock->disableDevice();
                date_default_timezone_set('America/Lima');
                $today = Carbon::now();
                $result = $clock->setTime($today);
                $clock->enableDevice();
                return $result;
            } 
        } 
    }

    public function getTime(Request $request, Clock $clock) {
        if($request->ajax()) {
            $clock = new ZKTeco($clock->ipAddress, $clock->port);
            if ($clock->connect()) {
                $clock->disableDevice();
                $result = $clock->getTime();
                $clock->enableDevice();
                return $result;
            } 
        } 
    }
   

    public function removeUser(Request $request, Clock $clock, $uid) {
        if($request->ajax()) {
            $clock = new ZKTeco($clock->ipAddress, $clock->port);
            if ($clock->connect()) {
                $clock->disableDevice();
                $result = $clock->removeUser($uid);
                $clock->enableDevice();
                return $result ;
            } 
        } 
    }

}
