<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\Attendee;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    // scanner page
    public function scannerPage(){
        $data = Attendee::select('attendees.*', 'scans.name')
                    ->join('scans', 'attendees.name', 'scans.name')
                    ->get();
        // dd($data->toArray());
        return view('qr_scan')->with(['data' => $data]);
    }

    public function scan(Request $request){
        $data = $this->getText($request);

        Scan::create($data);

        return back();
    }

    private function getText($request){
        return [
            'name' => $request->text,
        ];
    }
}
