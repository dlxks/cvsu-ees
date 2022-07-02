<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Mail\ScheduleMail;
use App\Models\Applicant;
use App\Models\College;
use App\Models\Exam;
use App\Models\Schedule;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;

class ScheduleController extends Controller
{

    use Banner;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->authorizeResource(Schedule::class);
    }

    public function index(Request $request)
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:sched_code,date,ctrl_num,status'],
        ]);

        $sched =  Schedule::latest()->get();

        $arr = [];

        foreach ($sched as $num) {
            for ($x = $num->applicant_id; $x <= $num->applicant_id; $x++) {
                if (!in_array($x, $arr))
                    array_push($arr, $x);
            }
        }

        $applicants = Applicant::select('id')
            ->whereNotIn('id', $arr)
            ->latest()
            ->get();

            
        $exam_names = Exam::latest()->get();

        $perpage = $request->input('perpage') ?: 25;

        $data = Schedule::with('exams');

        if (request('search')) {
            $data
                ->where('schedules.sched_code', 'like', '%' . request('search') . '%')
                ->orwhere('schedules.sched_name', 'like', '%' . request('search') . '%')
                ->orwhere('schedules.date', 'like', '%' . request('search') . '%')
                ->orwhere('schedules.applicant_id', 'like', '%' . request('search') . '%')
                ->orwhere('schedules.status', 'like', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $data->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/Schedule/Index', [
            'schedules' => $data->paginate($perpage)->withQueryString(),
            'applicants' => $applicants,
            'filters' => request()->all(['search', 'field', 'direction', 'perpage']),
            'exam_names' => $exam_names,
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
        $date_now = Carbon::now('Asia/Hong_Kong')->format('Y-m-d');
        $date = date('Y-m-d', strtotime($request['date']));

        $val = Validator::make($request->all(), [
            'exams' => ['required'],
            'sched_name' => ['required'],
            'start_ctrl_num' => ['required'],
            'end_ctrl_num' => ['required'],
            'date' => ['required', 'date'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $sched_code = IdGenerator::generate(['table' => 'schedules', 'field' => 'sched_code', 'length' => 8, 'prefix' => 'SCH-', 'reset_on_prefix_change' => true]);

        $arr = [];
        for ($x = substr($request->start_ctrl_num, 4); $x <= substr($request->end_ctrl_num, 4); $x++) {

            if (!in_array($x, $arr)) {
                array_push($arr, $x);
            }

            $sched = Schedule::create([
                'sched_code' => $sched_code,
                'sched_name' => $request['sched_name'],
                'applicant_id' => $x,
                'status' => $date == $date_now ? 'active' : 'pending',
                'date' => date('Y-m-d', strtotime($request['date'])),
            ]);
        }

        $exids = [];
        foreach ($request['exams'] as $ex) {
            array_push($exids, $ex['id']);
        }

        // dd($excodes);
        $sched->exams()->sync($exids);

        // EMAIL
        // $data = [
        //     'name' => $request['name'],
        //     'status' => $request['status'],
        //     'course' => $request['course'],
        //     'regards' => 'Cavite State University-Main Campus',
        // ];

        $this->flash('Schedule created!', 'success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {

        $date_now = Carbon::now('Asia/Hong_Kong')->format('Y-m-d');

        $date = date('Y-m-d H:i:s', strtotime($request->date));

        $val = Validator::make($request->all(), [
            'sched_name' => ['required'],
            'applicant_id' => ['required'],
            'date' => ['required', 'date'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $schedule->update([
            'sched_name' => $request->sched_name,
            'applicant_id' => $request->applicant_id,
            'date' => $date,
        ]);

       if($date == $date_now){
            $schedule->update(['status' => 'active']);
       }else if($date > $date_now){
            $schedule->update(['status' => 'pending']);
       }else if($date < $date_now){
            $schedule->update(['status' => 'ended']);
       }

       
       $exids = [];
       foreach ($request['exams'] as $ex) {
           array_push($exids, $ex['id']);
       }
       $schedule->exams()->sync($exids);

        $this->flash('Schedule updated successfully.', 'success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $d = Schedule::find($id);
        // $d->colleges()->detach();
        $d->exams()->detach();
        $d->delete();

        $this->flash('Schedule removed.', 'success');

        return redirect()->back();
    }


    public function sendNotification(Request $request)
    {
        $applicants = \DB::table('schedules')
            ->join('applicants', 'schedules.applicant_id', '=', 'applicants.id')
            ->select(
                'applicants.id',
                'applicants.fname',
                'applicants.mname',
                'applicants.lname',
                'applicants.email',
                'applicants.phone_number',
                'schedules.sched_name',
                'schedules.date'
            )
            ->where('schedules.status', '=', 'pending')
            ->get();


        if (count($applicants) < 1) {
            $this->flash('No pending schdules.', 'danger');
            return redirect()->back();
        } elseif (count($applicants) > 0) {
            foreach ($applicants as $applicant) {
                $data = [
                    'ctrl_num' => $applicant->id,
                    'name' => $applicant->lname . ', ' . $applicant->fname . ' ' . $applicant->mname,
                    'email' => $applicant->email,
                    'phone_number' => $applicant->phone_number,
                    'sched_name' => $applicant->sched_name,
                    'date' => $applicant->date,
                    'regards' => 'Cavite State University-Main Campus',
                ];


                // dd($applicant->email);
                Mail::to($applicant->email)->send(new ScheduleMail($data));
            }

            $this->flash('Schedule sent!', 'success');

            return redirect()->back();
        }
    }
}
