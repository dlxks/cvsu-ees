<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApplicantsExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Models\Applicant;
use App\Models\College;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        if (request('search')) {
            $data
                ->where('applicants.id', 'like', '%' . request('search') . '%')
                ->orwhere('applicants.fname', 'like', '%' . request('search') . '%')
                ->orWhere('applicants.mname', 'like', '%' . request('search') . '%')
                ->orWhere('applicants.lname', 'like', '%' . request('search') . '%')
                ->orWhere('applicants.email', 'like', '%' . request('search') . '%')
                ->orWhere('applicants.phone_number', 'like', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $data->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/Applicant/Index', [
            'applicants' => $data->paginate($perpage)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction', 'perpage']),
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:applicants'],
            'phone_number' => ['required', 'integer', 'unique:applicants', 'regex:/^(63)[0-9]{10}$/'],
            'birthday' => ['required', 'date'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }
        $user = User::create([
            'name' =>  Str::of($request['lname'])->ucfirst() . ', ' . Str::of($request['fname'])->ucfirst() . ' ' . Str::of($request['mname'])->ucfirst(),
            'email' => $request['email'],
            'phone' => $request['phone_number'],
            'role' => 'applicant',
            'password' => bcrypt('changetorandomstring')
        ]);

        $applicant = Applicant::create([
            'user_id' => $user->id,
            'fname' => Str::of($request['fname'])->ucfirst(),
            'mname' => Str::of($request['mname'])->ucfirst(),
            'lname' => Str::of($request['lname'])->ucfirst(),
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'birthday' => $request['birthday'],
        ]);

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
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['required', 'integer', 'regex:/^(63)[0-9]{10}$/'],
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
            'phone' => $request['phone_number'],
        ]);

        $applicant->update([
            'fname' => Str::of($request['fname'])->ucfirst(),
            'mname' => Str::of($request['mname'])->ucfirst(),
            'lname' => Str::of($request['lname'])->ucfirst(),
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'birthday' => $request['birthday'],
        ]);

        $this->flash('Applicant updated!', 'success');

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
        $d = Applicant::find($id);
        $d->colleges()->detach();
        $d->delete();

        $this->flash('Applicant removed.', 'success');

        return redirect()->back();
    }

    protected function resourceAbilityMap()
    {
        return array_merge(parent::resourceAbilityMap(), ['applicantsExport' => 'applicantsExport']);
    }
}
