<?php

namespace App\Http\Controllers;

use App\Models\Chatbot;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noOfExams = DB::table('exams')->count();
        $noOfApplicants = DB::table('applicants')->count();
        $noOfSched = DB::table('schedules')
            ->where('status', 'pending')
            ->orWhere('status', 'active')
            ->count();

        $data = Schedule::groupBy('sched_code', 'date', 'sched_name', 'status')
            ->select('sched_code', 'date', 'sched_name', 'status', DB::raw('count(*) as total'))
            ->where('status', 'pending')
            ->orWhere('status', 'active')
            ->orderBy('date', 'desc');

        $contacts = Chatbot::where('category', 'Contact Information')
            ->orderBy('question', 'asc')
            ->get();

        // dd($contacts);

        return Inertia::render('Index', [
            'noOfExams' => $noOfExams,
            'noOfApplicants' => $noOfApplicants,
            'noOfSched' => $noOfSched,
            'schedules' => $data->paginate(30)->withQueryString(),
            'contacts' => $contacts,
        ]);
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
