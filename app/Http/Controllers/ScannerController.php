<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Scan;
use App\Models\Attendee;
use App\Models\FirstDayScan;
use Illuminate\Http\Request;
use App\Models\SecondDayScan;

class ScannerController extends Controller
{
    // scanner page
    public function scannerPage(){

        return view('qr_scan');
    }

    // first day table
    public function firstDayPage(){
        $firstDayData = Attendee::select('attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name', 'first_day_scans.*')
                ->join('first_day_scans', 'attendees.randomNum', 'first_day_scans.randomNum')
                ->get();

        return view('firstDay')->with(['firstDay' => $firstDayData]);
    }

    // second day table
    public function secondDayPage(){
        $secondDayData = Attendee::select('attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name', 'second_day_scans.*')
                ->join('second_day_scans', 'attendees.randomNum', 'second_day_scans.randomNum')
                ->get();
        return view('secondDay')->with(['secondDay' => $secondDayData]);
    }

    // scanning process
    public function scan(Request $request){
        $qrData = $this->getText($request);
        $date = Carbon::now();

        $role = Attendee::select('role')->get();

        if($date->isSameDay("2022-12-24")){
            FirstDayScan::create($qrData);
        } elseif($date->isSameDay("2022-12-25")){
            SecondDayScan::create($qrData);
        }

        return back();
    }

    // get text from qr code
    private function getText($request){
        return [
            'randomNum' => $request->text,
        ];
    }
}
