<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Result;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicantDashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:applicant');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $authApplicant = auth()->user()->id;
        $applicant = Applicant::where('user_id', $authApplicant)->first();
        $schedule = Schedule::where('applicant_id', $applicant->id)->first();

        // $schedule = auth()->user()->applicantAccount->schedule;
        // $sched_date = date('F j, Y', strtotime($schedule->date));

        $result = Result::with('courses', 'applicant')->where('applicant_id', $applicant->id)->first();
        // dd($applicant->id);

        return Inertia::render('Applicant/Dashboard/Index', [
            'schedule' => $schedule,
            // 'date' => $sched_date,
            'result' => $result,

        ]);
        // $authApplicant = auth()->user()->id;
        // $applicant = Applicant::where('user_id', $authApplicant)->first();

        // $schedule = Schedule::where('applicant_id', $applicant->id)->first();

        // $applicant_schedule = auth()->user()->applicantAccount->schedule;
        // $result = Result::with('courses', 'applicant')->where('applicant_id', $applicant->id)->first();

        // dd($schedule);

        // return Inertia::render('Applicant/Dashboard/Index', [
        //     'schedule' => $schedule,
        //     'result' => $result,
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
