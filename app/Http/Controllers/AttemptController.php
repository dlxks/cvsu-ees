<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Attempt;
use App\Models\Exam;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Attempt  $attempt
     * @return \Illuminate\Http\Response
     */
    public function show(Attempt $attempt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attempt  $attempt
     * @return \Illuminate\Http\Response
     */
    public function edit(Attempt $attempt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attempt  $attempt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attempt $attempt)
    {
        // $authApplicant = auth()->user()->id;
        // $applicant = Applicant::where('user_id', $authApplicant)->first();
        // $attempt = Attempt::where('applicant_id', $applicant->id)->first();

        // $applicant_id = $applicant->id;
        // $exam_id = $attempt->exam_id;

        // $exam = Exam::find($exam_id);
        // $duration = Exam::where('id', $exam_id)->value('duration');

        // Attempt::updateOrCreate(
        //     [
        //         'applicant_id' => $applicant_id,
        //         'exam_id' => $exam_id,
        //     ],
        //     [
        //         'time_left' => $duration,
        //     ],
        // );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attempt  $attempt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attempt $attempt)
    {
        //
    }
}
