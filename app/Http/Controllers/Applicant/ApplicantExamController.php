<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Models\Answer;
use App\Models\Applicant;
use App\Models\Attempt;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Result;
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
        $authApplicant = auth()->user()->id;
        $applicant = Applicant::where('user_id', $authApplicant)->first();

        $schedule = Schedule::with('exams')->where('applicant_id', $applicant->id)->first();
        $attempts = Attempt::where('applicant_id', $applicant->id)->get();
        $results = Result::where('applicant_id', $applicant->id)->get();

        $exams = null;
        $questions = null;

        if ($schedule) {
            if ($schedule->status == 'active') {
                $exams = Exam::where('status', 'active')->latest()->get();
                $questions = Exam::with('questions')->get();
            } else {
                $exams = Exam::where('status', 'active')->latest()->get();
                $questions = null;
            }
        }

        return Inertia::render('Applicant/Exam/Index', [
            'exams' => $exams,
            'questions' => $questions,
            'attempts' => $attempts,
            'results' => $results,
            'schedule' => $schedule,
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

        // IDs
        $applicant_id = $applicant->id;
        $exam_id = $exam->id;

        $schedule = Schedule::where('applicant_id', $applicant_id)->first();
        $attempt = Attempt::where([
            ['applicant_id', $applicant_id],
            ['exam_id', $exam->id]
        ])
            ->first();

        $results = Result::where('applicant_id', $applicant_id)->get();

        $exam = Exam::find($exam_id);
        $questions = Question::with('choices')->where('exam_id', $exam_id)->inRandomOrder()->get();
        $answers = Answer::where(
            [
                ['applicant_id', $applicant_id],
                ['exam_id', $exam_id],
            ]
        )->get();

        if ($schedule->status == 'ended') {
            $this->flash("The exam has ended. You are not allowed to take it again.", 'danger');
            return back();
        }

        if ($schedule->status == 'pending') {
            $this->flash("You are not scheduled to take the exam today.", 'danger');
            return back();
        }

        $duration = Exam::where('id', $exam_id)->value('duration');
        $start_time = Carbon::now();
        $end_time = $start_time->addMinutes($duration)->format('Y-m-d H:i:s');
        $curr_time = Carbon::now()->format('Y-m-d H:i:s');

        if ($schedule->status == 'active') {
            // If results are empty
            if ($results->isEmpty()) {
                // create attempt
                if (!$attempt) {
                    Attempt::create(
                        [
                            'applicant_id' => $applicant->id,
                            'exam_id' => $exam_id,
                            'start_time' => $curr_time,
                            'end_time' => $end_time,
                        ],
                    );

                    return Inertia::render('Applicant/Exam/Show', [
                        'exam' => $exam,
                        'questions' => $questions,
                        'answers' => $answers,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                    ]);
                }
                // attempt ended
                if ($attempt->applicant_id == $applicant_id && $attempt->exam_id == $exam_id && $attempt->end_time < $curr_time) {
                    $this->flash("Your attempt for this exam was finished.", 'danger');
                    return back();
                }
                // continue attempt
                if ($attempt->applicant_id == $applicant_id && $attempt->exam_id == $exam_id && $curr_time < $attempt->end_time) {

                    return Inertia::render('Applicant/Exam/Show', [
                        'exam' => $exam,
                        'questions' => $questions,
                        'answers' => $answers,
                        'start_time' => $attempt->start_time,
                        'end_time' => $attempt->end_time,
                    ]);
                }
            }
            // If there are results
            else {
                // Get exam
                $res_check = Result::where(
                    [
                        ['applicant_id', $applicant_id],
                        ['exam', $exam->exam_code],
                    ]
                )->first();

                if (!$res_check) {
                    // create attempt
                    if (!$attempt) {
                        Attempt::create(
                            [
                                'applicant_id' => $applicant->id,
                                'exam_id' => $exam_id,
                                'start_time' => $curr_time,
                                'end_time' => $end_time,
                            ],
                        );

                        return Inertia::render('Applicant/Exam/Show', [
                            'exam' => $exam,
                            'questions' => $questions,
                            'answers' => $answers,
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'result' => $res_check,
                        ]);
                    }
                    // attempt ended
                    if ($attempt->applicant_id == $applicant_id && $attempt->exam_id == $exam_id && $attempt->end_time < $curr_time) {
                        $this->flash("Your attempt for this exam was finished.", 'danger');
                        return back();
                    }
                    // continue attempt
                    if ($attempt->applicant_id == $applicant_id && $attempt->exam_id == $exam_id && $curr_time < $attempt->end_time) {
                        return Inertia::render('Applicant/Exam/Show', [
                            'exam' => $exam,
                            'questions' => $questions,
                            'answers' => $answers,
                            'start_time' => $attempt->start_time,
                            'end_time' => $attempt->end_time,
                        ]);
                    }
                } elseif ($res_check->applicant_id && $res_check->exam != $exam->exam_code) {
                    // create attempt
                    if (!$attempt) {
                        Attempt::create(
                            [
                                'applicant_id' => $applicant->id,
                                'exam_id' => $exam_id,
                                'start_time' => $curr_time,
                                'end_time' => $end_time,
                            ],
                        );

                        return Inertia::render('Applicant/Exam/Show', [
                            'exam' => $exam,
                            'questions' => $questions,
                            'answers' => $answers,
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'result' => $res_check,
                        ]);
                    }
                    // attempt ended
                    if ($attempt->applicant_id == $applicant_id && $attempt->exam_id == $exam_id && $attempt->end_time < $curr_time) {
                        $this->flash("Your attempt for this exam was finished.", 'danger');
                        return back();
                    }
                    // continue attempt
                    if ($attempt->applicant_id == $applicant_id && $attempt->exam_id == $exam_id && $curr_time < $attempt->end_time) {

                        return Inertia::render('Applicant/Exam/Show', [
                            'exam' => $exam,
                            'questions' => $questions,
                            'answers' => $answers,
                            'start_time' => $attempt->start_time,
                            'end_time' => $attempt->end_time,
                        ]);
                    }
                } else {
                    $this->flash("Exam has been taken. Please check the result.", 'danger');
                    return back();
                }
            }
        }
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
