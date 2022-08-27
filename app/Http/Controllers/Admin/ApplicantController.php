<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApplicantsExport;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Models\Applicant;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use PDF;

class ApplicantController extends Controller
{
    use Banner;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:fname,mname,lname,email,phone_number'],
        ]);


        $data = Applicant::query();
        $perpage = $request->input('perpage') ?: 25;
        $courses = Course::latest()->get();

        if (request('search')) {
            $data
                ->where('id', 'like', '%' . request('search') . '%')
                ->orwhere('fname', 'like', '%' . request('search') . '%')
                ->orWhere('.mname', 'like', '%' . request('search') . '%')
                ->orWhere('.lname', 'like', '%' . request('search') . '%')
                ->orWhere('course_applied', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%')
                ->orWhere('phone_number', 'like', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $data->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/Applicant/Index', [
            'applicants' => $data->paginate($perpage)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction', 'perpage']),
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
        $val = Validator::make($request->all(), [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:applicants', 'unique:users'],
            'course_applied' => ['required'],
            'phone_number' => ['required', 'unique:applicants', 'numeric', 'min:10'],
            'birthday' => ['required', 'date'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        if ($val) {
            $user = User::create([
                'name' =>  Str::of($request['lname'])->ucfirst() . ', ' . Str::of($request['fname'])->ucfirst() . ' ' . Str::of($request['mname'])->ucfirst(),
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'role' => 'applicant',
                'password' => bcrypt('changetorandomstring')
            ]);

            $applicant_id = Helper::IDGenerator(new Applicant(), 'id', 5, date('ym')); /** Generate id */

            $applicant = Applicant::create([
                'id' => $applicant_id,
                'user_id' => $user->id,
                'fname' => Str::of($request['fname'])->ucfirst(),
                'mname' => Str::of($request['mname'])->ucfirst(),
                'lname' => Str::of($request['lname'])->ucfirst(),
                'course_applied' => Str::of($request['course_applied'])->upper(),
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'birthday' => $request['birthday'],
            ]);
        }


        $this->flash('Applicant added', 'success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function edit(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Applicant $applicant)
    {
        $val = Validator::make($request->all(), [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'course_applied' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['required', 'numeric', 'min:10'],
            'birthday' => ['required', 'date'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $user = User::where('users.id', '=', $applicant->user_id)
            ->first();

        $user->update([
            'name' =>  Str::of($request['lname'])->ucfirst() . ', ' . Str::of($request['fname'])->ucfirst() . ' ' . Str::of($request['mname'])->ucfirst(),
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
        ]);

        $applicant->update([
            'fname' => Str::of($request['fname'])->ucfirst(),
            'mname' => Str::of($request['mname'])->ucfirst(),
            'lname' => Str::of($request['lname'])->ucfirst(),
            'course_applied' => Str::of($request['course_applied'])->upper(),
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'birthday' => $request['birthday'],
        ]);

        if ($val) {
            $this->flash('Applicant updated!', 'success');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicant = Applicant::find($id);

        $userid = $applicant->user_id;
        $user = User::where('id', $userid)->first();

        $user->delete();
        $applicant->delete();

        $this->flash('Applicant removed.', 'success');

        return redirect()->back();
    }

    protected function resourceAbilityMap()
    {
        return array_merge(parent::resourceAbilityMap(), ['applicantsExport' => 'applicantsExport']);
    }

    // Export function
    public function export()
    {
        $date = Carbon::now()->format('d-m-Y');

        if (request()->has('type')) {
            if (request()->get('type') == 'xlsx') {
                return Excel::download(new ApplicantsExport, $date . '-applicants.xlsx');
            } elseif (request()->get('type') == 'csv') {
                return Excel::download(new ApplicantsExport, $date . '-applicants.csv');
            }
        }
        return back();
    }

    public function generate_pdf()
    {
        $date = Carbon::now()->format('d-m-Y');
        $data = Applicant::orderBy('lname', 'asc')->get();
        $ddate = Carbon::now()->format('d/m/Y');

        $pdf = PDF::loadView('pdf.applicants', [
            'data' => $data,
            'ddate' => $ddate,
        ]);

        return $pdf->stream($date . '-applicants.pdf');
    }
}
