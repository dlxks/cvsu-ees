<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ResultsExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Mail\ResultMail;
use App\Models\Applicant;
use App\Models\Course;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ResultController extends Controller
{

    use Banner;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->authorizeResource(Result::class);
    }

    public function index(Request $request)
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:applicant_id,name,exam,score,course,status'],
        ]);

        $course_names = Course::latest()->get();
        $applicant = Result::with('applicant')
            ->where('results.applicant_id', '=', 'applicants.id');

        $data = Result::orderBy('score', 'desc');
        $perpage = $request->input('perpage') ?: 25;

        if (request('search')) {
            $data
                ->orwhere('results.applicant_id', 'like', '%' . request('search') . '%')
                ->orWhere('results.name', 'like', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $data->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/Result/Index', [
            'results' => $data->paginate($perpage)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction', 'perpage']),
            'course_names' => $course_names,
            'applicant' => $applicant,
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
    public function show(Result $result)
    {
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
    public function update(Request $request, Result $result)
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

    // Export function
    public function export()
    {
        $date = Carbon::now()->format('d-m-Y');

        if (request()->has('type')) {
            if (request()->get('type') == 'xlsx') {
                return Excel::download(new ResultsExport, $date . '-results.xlsx');
            } elseif (request()->get('type') == 'csv') {
                return Excel::download(new ResultsExport, $date . '-results.csv');
            }
        }
        return back();
    }

    public function generate_pdf()
    {
        $results = Result::with('applicant')
            ->orderBy('results.applicant_id', 'asc')
            ->get();

        $date = Carbon::now()->format('d/m/Y');

        $pdf = PDF::loadView('pdf.results', [
            'results' => $results,
            'date' => $date,
        ]);

        return $pdf->stream($date . '*results.pdf');
    }
}
