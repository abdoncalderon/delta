<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use Dflydev\DotAccessData\Util;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laradevsbd\Zkteco\Http\Library\ZKLib;
use Laradevsbd\Zkteco\Http\Library\ZktecoLib;
use Rats\Zkteco\Lib\ZKTeco;

class TimeSheetController extends Controller
{
    
    public function home() {
        return Inertia::render('People/TimeSheet/Home', [
           
        ]);
    }
    
    public function index() {
        $clock = new ZKTeco('10.16.162.131','4370');
        if ($clock->connect()) {
            $clock->disableDevice();
            $serialNunmber = $clock->serialNumber();
            $deviceName = $clock->deviceName();
            $firmwareVersion = $clock->fmVersion();
            $platform = $clock->platform();
            $clock->enableDevice();
           
        } 
        return Inertia::render('People/TimeSheet/Index', [
            'serialNumber' => $serialNunmber,
            'deviceName' => $deviceName,
            'firmwareVersion' => $firmwareVersion,
            'platform' => $platform, 
        ]);
    }

    
    
}
