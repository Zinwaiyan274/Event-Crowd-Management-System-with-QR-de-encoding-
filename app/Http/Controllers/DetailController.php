<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\FirstDayScan;
use Illuminate\Http\Request;
use App\Models\SecondDayScan;

class DetailController extends Controller
{
    public function detail(){
            $detail = Attendee::when(request('search'),function($query){
                $query->where('name','like','%'.request('search').'%')
                    ->orWhere('role','like','%'.request('search').'%')
                    ->orWhere('company_name','like','%'.request('search').'%');
                })
                ->simplePaginate(10);

        $total_people = Attendee::count();
        $first_people = FirstDayScan::count();

        return view('detail',['detail' => $detail, 'total_people' => $total_people, 'first_people' => $first_people]);
    }

    public function firstDayDetail(){
        $firstDayData = Attendee::when(request('search'),function($query){
                        $query->where('name','like','%'.request('search').'%')
                              ->orWhere('role','like','%'.request('search').'%')
                              ->orWhere('company_name','like','%'.request('search').'%');
                    })
                    ->where('firstDayScan',1)
                    ->simplePaginate(10);
        $total_people = Attendee::count();
        $first_people = FirstDayScan::count();

        return view('firstDayDetail',['firstDayData' => $firstDayData, 'total_people' => $total_people, 'first_people' => $first_people]);
    }

    public function secondDayDetail(){
        $secondDayData = Attendee::when(request('search'),function($query){
                        $query->where('name','like','%'.request('search').'%')
                              ->orWhere('role','like','%'.request('search').'%')
                              ->orWhere('company_name','like','%'.request('search').'%');
                    })
                    ->where('secondDayScan',1)
                    ->simplePaginate(10);
        $total_people = Attendee::count();
        $first_people = SecondDayScan::count();

        return view('secondDayDetail',['secondDayData' => $secondDayData, 'total_people' => $total_people, 'first_people' => $first_people]);
    }

    //filter by company name
    public function filterByCompany(Request $request){
        //all day company name filter
        $all_day_filter_data = Attendee::where('attendees.company_name',$request->filter)
                                ->simplePaginate(10);

        //first day company name filter
        $first_day_filter_data = Attendee::select('first_day_scans.randomNum', 'first_day_scans.created_at','attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name')
                                ->join('first_day_scans', 'attendees.randomNum', 'first_day_scans.randomNum')
                                ->where('attendees.company_name',$request->filter)
                                ->simplePaginate(10);

        //second day company name filter
        $second_day_filter_data = Attendee::select('second_day_scans.randomNum', 'second_day_scans.created_at','attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name')
                                ->join('second_day_scans', 'attendees.randomNum', 'second_day_scans.randomNum')
                                ->where('attendees.company_name',$request->filter)
                                ->simplePaginate(10);

        // first day peoole filter
        $first_day_people = FirstDayScan::select('first_day_scans.randomNum', 'first_day_scans.created_at','attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name')
                        ->join('attendees', 'attendees.randomNum', 'first_day_scans.randomNum')
                        ->where('attendees.company_name',$request->filter)
                        ->count();



        // second day people filter
        $second_day_people = SecondDayScan::select('second_day_scans.randomNum', 'second_day_scans.created_at','attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name')
                        ->join('attendees', 'attendees.randomNum', 'second_day_scans.randomNum')
                        ->where('attendees.company_name',$request->filter)
                        ->count();

        // all day people filter
        $people = Attendee::where('company_name',$request->filter)->count();

        //total people
        $total_people = Attendee::count();

        return response()->json([
            'filter_data' => $all_day_filter_data,
            'first_filter_data' => $first_day_filter_data,
            'second_filter_data' => $second_day_filter_data,
            'first_people' => $first_day_people,
            'second_people' => $second_day_people,
            'total_people' => $total_people,
            'filter_people' => $people
        ]);
    }

    // filter by role
    public function filterByRole(Request $request){
        // all day role filter
        $all_day_filter_data = Attendee::where('attendees.role',$request->filter_role)
                            ->simplePaginate(10);

        // first day role filter
        $first_day_filter_data = Attendee::select('first_day_scans.randomNum', 'first_day_scans.created_at','attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name')
                    ->join('first_day_scans', 'attendees.randomNum', 'first_day_scans.randomNum')
                    ->where('attendees.role',$request->filter_role)
                    ->simplePaginate(10);

         // first day role filter
        $second_day_filter_data = Attendee::select('second_day_scans.randomNum', 'second_day_scans.created_at','attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name')
                                ->join('second_day_scans', 'attendees.randomNum', 'second_day_scans.randomNum')
                                ->where('attendees.role',$request->filter_role)
                                ->simplePaginate(10);

        // first day people filter
        $first_people = FirstDayScan::select('first_day_scans.randomNum', 'first_day_scans.created_at','attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name')
                        ->join('attendees', 'attendees.randomNum', 'first_day_scans.randomNum')
                        ->where('attendees.role',$request->filter_role)
                        ->count();
        // total people
        $total_people = Attendee::count();

        // second day people filter
        $second_people = SecondDayScan::select('second_day_scans.randomNum', 'second_day_scans.created_at','attendees.id', 'attendees.name', 'attendees.role', 'attendees.company_name')
                        ->join('attendees', 'attendees.randomNum', 'second_day_scans.randomNum')
                        ->where('attendees.role',$request->filter_role)
                        ->count();

        // all day people filter
        $people = Attendee::where('role',$request->filter_role)->count();


        return response()->json([
            'filter_data' => $all_day_filter_data,
            'first_filter_data' => $first_day_filter_data,
            'second_filter_data' => $second_day_filter_data,
            'total_people' => $total_people,
            'first_people' => $first_people,
            'second_people' => $second_people,
            'people' => $people
        ]);
    }

    //filter by attend or not
    public function filterByAttend(Request $request){

        if($request->filter_attend == 'attend'){
            $filter_attend_data = Attendee::where('firstDayScan',1)
                                ->where('secondDayScan',1)
                                ->simplePaginate(10);
        }else{
            $filter_attend_data = Attendee::where('firstDayScan',0)
                                    ->where('secondDayScan',0)
                                    ->simplePaginate(10);
        }

        $total_people = Attendee::count();

        $attend_people = Attendee::where('firstDayScan',1)
                                ->where('secondDayScan',1)
                                ->count();

        $not_attend_people = Attendee::where('firstDayScan',0)
                        ->where('secondDayScan',0)
                        ->count();

        return response()->json([
            'filter_attend' => $filter_attend_data,
            'attend_people' => $attend_people,
            'not_attend_people'=> $not_attend_people,
            'total_people' => $total_people
        ]);
    }

    }

