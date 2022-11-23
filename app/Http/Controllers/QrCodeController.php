<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    // generate page
    public function generateQrPage() {
        $data = Attendee::simplePaginate(1);
        $count = Attendee::count();

        return view('index')->with(['data' => $data, 'count' => $count]);
    }

    // generating process
    public function generateQr(Request $request){
        // $userData = implode($this->requestDataWithoutQR($request));
        $name = $request->name;

        $qr = QrCode::format('png')
                        ->size(200)->errorCorrection('H')
                        ->backgroundColor(255, 255, 255)
                        ->generate($name);

        $output_file = time() . '.png';
        Storage::disk('public')->put($output_file, $qr);

        $data = $this->requestDataWithQR($request, $output_file);

        Attendee::create($data);

        return back();
    }

    // input data with qr code
    private function requestDataWithQR($request, $output_file){
        return [
            'name' => $request->name,
            'role' => $request->role,
            'company_name' => $request->companyName,
            'qr' => $output_file,
        ];
    }

    // input data without qr code
    // private function requestDataWithoutQR($request){
    //     return [
    //         'name' => $request->name,
    //         'role' => $request->role,
    //         'company_name' => $request->companyName,
    //     ];
    // }
}
