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

        if($date->isSameDay("2022-12-24")){
            FirstDayScan::create($qrData);
            Attendee::select('randomNum')->where('randomNum', $qrData)->update(['firstDayScan'=>1]);
        } elseif($date->isSameDay("2022-12-25")){
            SecondDayScan::create($qrData);
            Attendee::select('randomNum')->where('randomNum', $qrData)->update(['secondDayScan'=>1]);
        }



        return back();
    }

    // csv download (first-day)
    public function firstDayCSV(){
        $firstDayData = Attendee::select('attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name', 'first_day_scans.*')
                ->join('first_day_scans', 'attendees.randomNum', 'first_day_scans.randomNum')
                ->get();

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($firstDayData, [
            'id' => 'Id',
            'name' => 'Name',
            'role' => 'Role(Title)',
            'company_name' => 'Company Name',
            'created_at' => 'Scanned Time',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'attenededList_firstDay.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // csv download (second-day)
    public function secondDayCSV(){
        $secondDayData = Attendee::select('attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name', 'second_day_scans.*')
                ->join('second_day_scans', 'attendees.randomNum', 'second_day_scans.randomNum')
                ->get();

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($secondDayData, [
            'id' => 'Id',
            'name' => 'Name',
            'role' => 'Role(Title)',
            'company_name' => 'Company Name',
            'created_at' => 'Scanned Time',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'attenededList_secondDay.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // get text from qr code
    private function getText($request){
        return [
            'randomNum' => $request->text,
        ];
    }
}
