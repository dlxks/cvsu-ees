<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Applicant;
use App\Models\Choice;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;

class ApplicantResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authApplicant = auth()->user()->id;
        $applicant = Applicant::where('user_id', $authApplicant)->first();

        $result = Result::with('courses', 'applicant')->where('applicant_id', $applicant->id)->first();

        $app_id = null;
        if ($result) {
            $app_id = $result->applicant_id;
        } else {
            $app_id = null;
        }


        $exam = Exam::query();
        $totalQuestions = Question::query();

        if ($result) {
            $exam = Exam::where('subject', $result->exam)->first();
            $totalQuestions = Question::where('exam_id', $exam->id)->count();
        } else {
            $exam = null;
            $totalQuestions = null;
        }

        return Inertia::render('Applicant/Result/Index', [
            'result' => $result,
            'totalQuestions' => $totalQuestions,
            'app_id' => $app_id,
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
        $examId = $request['examId'];
        $questionId = $request['questionId'];
        $answerId = $request['answerId'];

        $authApplicant = auth()->user()->id;
        $applicant = Applicant::where('user_id', $authApplicant)->first();

        $exam = Exam::where('id', $examId)->first();

        $answers = Answer::where('applicant_id', $applicant->id)->where('exam_id', $examId)->where('question_id', '!=', 0)->with('question')->with('choice')->get();
        $choice = Choice::query()->get();

        $ans = [];
        foreach ($answers as $answer) {
            array_push($ans, $answer->answer_id);
        }
        $totalQuestions = Question::where('exam_id', $examId)->count();
        $correctAnswer = Choice::whereIn('id', $ans)->where('is_correct', 1)->count();

        $rated = ($correctAnswer / $totalQuestions) * 100;

        Result::updateOrCreate(
            [
                'applicant_id' => $applicant->id,
            ],
            [
                'name' => Str::of($applicant->lname)->ucfirst() . ', ' . Str::of($applicant->fname)->ucfirst() . ' ' . Str::of($applicant->mname)->ucfirst(),
                'exam' => $exam->subject,
                'score' => $rated,
            ]
        );

        return redirect(route('applicant.results.index'));
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

    public function export_pdf(Request $request)
    {
        $applicant_id = $request['applicant_id'];
        $result  = Result::with('courses', 'applicant')
            ->where('applicant_id', $applicant_id)
            ->first();
        // dd($result);
        $date = Carbon::now()->format('d/m/Y');
        $name = $result->applicant->lname;

        $pdf = PDF::loadView('pdf.appres', compact('result', 'date'));
        return $pdf->download('result.pdf');
    }
}
