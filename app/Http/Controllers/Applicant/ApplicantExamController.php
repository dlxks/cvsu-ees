<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Models\Answer;
use App\Models\Applicant;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ApplicantExamController extends Controller
{
    use Banner;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $authApplicant = auth()->user()->id;
        // $applicant = Applicant::where('user_id', $authApplicant)->first();

        // $schedule = Schedule::where('applicant_id', $applicant->id)->first();

        // if ($schedule->status == 'active') {
        //     $exams = Exam::where('status', 'active')->latest()->get();
        //     $questions = Exam::with('questions')->get();
        // } else {
        //     $exams = Exam::query();
        //     $questions = null;
        // }

        $applicant_exams = auth()->user()->applicantAccount->schedule->exams;

        return Inertia::render('Applicant/Exam/Index', [
            'exams' => $applicant_exams,
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
    public function show(Request $request, Exam $exam)
    {
        $authApplicant = auth()->user()->id;
        $applicant = Applicant::where('user_id', $authApplicant)->first();

        $schedule = Schedule::where('applicant_id', $applicant->id)->first();

        if ($schedule->status == 'inactive') {
            $this->flash("You are not allowed to take this exam or you're not scheduled for today.", 'danger');
            return back();
        }

        $applicant_id = $applicant->id;
        $exam_id = $exam->id;

        $exam = Exam::find($exam_id);
        $questions = Question::with('choices')->where('exam_id', $exam_id)->inRandomOrder()->get();
        $duration = Exam::where('id', $exam_id)->value('duration');

        $examHasTaken = Answer::where(['applicant_id' => $applicant_id, 'exam_id' => $exam_id])->get();
        $wasCompleted = Answer::where('applicant_id', $applicant_id)->whereIn('exam_id', (new Exam)->hasExamAttempted())->pluck('exam_id')->toArray();

        if (in_array($exam_id, $wasCompleted)) {
            $this->flash("You already taken this exam.", 'danger');
            return back();
        }

        return Inertia::render('Applicant/Exam/Show', [
            'exam' => $exam,
            'duration' => $duration,
            'questions' => $questions,
            'examHasTaken' => $examHasTaken,
        ]);
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

    public function postExam(Request $request)
    {
        $examId = $request['examId'];
        $questionId = $request['questionId'];
        $answerId = $request['answerId'];

        $authApplicant = auth()->user()->id;
        $applicant = Applicant::where('user_id', $authApplicant)->first();

        // dd($applicant->id);
        return Answer::updateOrCreate(
            [
                'applicant_id' => $applicant->id,
                'exam_id' => $examId,
                'question_id' => $questionId,
            ],
            [
                'answer_id' => $answerId
            ],
        );
    }
}
