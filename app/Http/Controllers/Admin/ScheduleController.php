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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Vonage\Client\Credentials\Basic;
use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Illuminate\Support\Str;

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
        $date_now = Carbon::now('Asia/Singapore')->format('Y-m-d');
        $date = date('Y-m-d h:i:s', strtotime($request['date']));

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

        $start = substr($request->start_ctrl_num, 4);
        $end = substr($request->end_ctrl_num, 4);
        $arr = [];

        $app_id = $request->start_ctrl_num;

        for ($x = $start; $x <= strval($end); $x++) {

            $n = str_pad($x, 6, "0", STR_PAD_LEFT);
            $sched = Schedule::create([
                'sched_code' => $sched_code,
                'sched_name' => Str::of($request['sched_name'])->upper(),
                'applicant_id' => $app_id,
                'status' => $date <= $date_now ? 'active' : 'pending',
                'date' => date('Y-m-d', strtotime($request['date'])),
            ]);
            $app_id++;

            $exids = [];
            foreach ($request['exams'] as $ex) {
                array_push($exids, $ex['id']);
            }
            $sched->exams()->sync($exids);
        }

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
            'date' => ['required', 'date'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $schedule->update([
            'sched_name' => $request->sched_name,
            'date' => $date,
        ]);

        if ($date == $date_now) {
            $schedule->update(['status' => 'active']);
        } else if ($date > $date_now) {
            $schedule->update(['status' => 'pending']);
        } else if ($date < $date_now) {
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
        $schedules =  Schedule::with('applicants')->where('status', 'pending')->get();

        if (count($schedules) < 1) {
            $this->flash('No pending schdules.', 'danger');
            return redirect()->back();
        } elseif (count($schedules) > 0) {
            foreach ($schedules as $schedule) {
                $sms_message = 'This is Cavite State University-Main Campus. You were scheduled to take the entrance examination on ' . $schedule->date . '.';
                // // SMS
                $basic  = new Basic("68ad8f1a", "4PMcuDQ5mVe0STkl");
                $client = new Client($basic);

                $response = $client->sms()->send(
                    new SMS($schedule->applicants->phone_number, 'Cavite State University-Main Campus', $sms_message)
                );

                $message = $response->current();

                if ($message->getStatus() == 0) {
                    $this->flash('Schedule was sent!', 'success');
                } else {

                    $this->flash('Schedule was not sent!', 'danger');
                }
                // Email
                $data = [
                    'ctrl_num' => $schedule->applicants->id,
                    'name' => $schedule->applicants->lname . ', ' . $schedule->applicants->fname . ' ' . $schedule->applicants->mname,
                    'email' => $schedule->applicants->email,
                    'phone_number' => $schedule->applicants->phone_number,
                    'sched_name' => $schedule->sched_name,
                    'date' => $schedule->date,
                    'regards' => 'Cavite State University-Main Campus',
                ];

                Mail::to($schedule->applicants->email)->send(new ScheduleMail($data));
            }

            $this->flash('Schedule sent!', 'success');

            return redirect()->back();
        }
    }
}
