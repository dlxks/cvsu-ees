<?php

namespace App\Http\Controllers\Admin;

use App\Exports\VerifiedExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Mail\ResultMail;
use App\Models\Applicant;
use App\Models\Course;
use App\Models\Result;
use App\Models\Verified;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;
use PDF;

class VerifiedController extends Controller
{
    use Banner;
    public function __construct()
    {
        $this->authorizeResource(Verified::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:applicant_id,name,rating,course_applied,status'],
        ]);

        $applicant = Applicant::with('verified', 'results')
            ->where('results.applicant_id', '=', 'applicants.id');
        $courses = Course::latest()->get();

        $data = Verified::query();
        $perpage = $request->input('perpage') ?: 25;

        if (request('search')) {
            $data
                ->orwhere('verifieds.applicant_id', 'like', '%' . request('search') . '%')
                ->orWhere('verifieds.name', 'like', '%' . request('search') . '%')
                ->orWhere('verifieds.rating', 'like', '%' . request('search') . '%')
                ->orWhere('verifieds.course_applied', 'like', '%' . request('search') . '%')
                ->orWhere('verifieds.status', 'like', '%' . request('search') . '%');
        }

        if (request()->has(['course'])) {
            $data
                ->orwhere('verifieds.course_applied', 'like', '%' . request('course') . '%');
        }

        if (request()->has(['status'])) {
            $data
                ->orwhere('verifieds.status', request('status'));
        }

        if (request()->has(['field', 'direction'])) {
            $data->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/Verified/Index', [
            'verifieds' => $data->paginate($perpage)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction', 'perpage', 'course', 'status']),
            'courses' => $courses,
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
     * @param  \App\Models\Verified  $verified
     * @return \Illuminate\Http\Response
     */
    public function show(Verified $verified)
    {
        $applicant = Applicant::where('applicants.id', '=', $verified->applicant_id)
            ->first();

        $courses = Course::latest()->get();
        $verified->with('course', 'applicant');
        $results = Result::with('applicant', 'exam')->where('applicant_id', $applicant->id)->get();

        return Inertia::render('Admin/Verified/Show', [
            'verified' => $verified,
            'applicant' => $applicant,
            'courses' => $courses,
            'results' => $results,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Verified  $verified
     * @return \Illuminate\Http\Response
     */
    public function edit(Verified $verified)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Verified  $verified
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Verified $verified)
    {
        $val = Validator::make($request->all(), [
            'applicant_id' => ['required'],
            'name' => ['required'],
            'rating' => ['required'],
            'course_applied' => ['required'],
            'status' => ['required'],
        ]);

        if ($request['status'] == 'qualified') {
            $val = Validator::make($request->all(), [
                'course_applied' => ['required'],
            ]);
        }

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $verified->updateOrCreate(
            [
                'applicant_id' => $request['applicant_id'],
            ],
            [
                'course_applied' => $request['course_applied'],
                'status' => $request['status'],
            ]
        );

        $this->flash('Result verified!', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Verified  $verified
     * @return \Illuminate\Http\Response
     */
    public function destroy(Verified $verified)
    {
        //
    }

    // Export function
    public function export()
    {
        $date = Carbon::now()->format('d-m-Y');

        if (request()->has('type')) {
            if (request()->get('type') == 'xlsx') {
                return Excel::download(new VerifiedExport, $date . '-verifiedresults.xlsx');
            } elseif (request()->get('type') == 'csv') {
                return Excel::download(new VerifiedExport, $date . '-verifiedresults.csv');
            }
        }
        return back();
    }

    public function generate_pdf()
    {
        $results = Verified::with('course', 'applicant')
            ->orderBy('verifieds.applicant_id', 'asc')
            ->get();

        // dd($results);
        $date = Carbon::now()->format('d/m/Y');

        $pdf = PDF::loadView('pdf.verified', [
            'results' => $results,
            'date' => $date,
        ]);

        return $pdf->stream($date . '*verifiedresults.pdf');
    }

    public function sendNotification(Request $request)
    {
        $app_id = $request['applicant_id'];
        $result = Verified::with('course', 'applicant')->where('applicant_id', $app_id)->first();

        $sms_message = 'This is Cavite State University-Main Campus. We would like to inform you that the results of your application is already out. Please check you email or the examination site to see the results. Thank you!';

        $phone = $request['phone_number'];
        $email = $request['email'];

        if ($request['status'] == 'qualified') {

            // // SMS
            $basic  = new Basic("68ad8f1a", "4PMcuDQ5mVe0STkl");
            $client = new Client($basic);

            $response = $client->sms()->send(
                new SMS($phone, 'Cavite State University-Main Campus', $sms_message)
            );

            $message = $response->current();

            if ($message->getStatus() == 0) {
                $this->flash('Results was sent!', 'success');
            } else {

                $this->flash('Results was not sent!', 'danger');
            }

            // EMAIL
            Mail::to($email)->send(new ResultMail($result));

            $this->flash('Result was sent!', 'success');

            return redirect()->back();
        } else {
            return redirect(route('admin.results.index'));
        }
    }
}
