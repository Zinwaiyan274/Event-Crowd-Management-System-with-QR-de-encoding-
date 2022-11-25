<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\Attendee;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    // scanner page
    public function scannerPage(){
        $data = Attendee::select('attendees.*', 'first_day_scans.randomNum')
                    ->join('first_day_scans', 'attendees.randomNum', 'first_day_scans.randomNum')
                    ->get();

        return view('qr_scan')->with(['data' => $data]);
    }

    public function scan(Request $request){
        $data = $this->getText($request);

        Scan::create($data);

        return back();
    }

    private function getText($request){
        return [
            'randomNum' => $request->text,
        ];
    }
}
