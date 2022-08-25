<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Models\College;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CourseController extends Controller
{
    use Banner;

    public function __construct()
    {
        $this->authorizeResource(Course::class);
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
            'field' => ['in:course_name,course_desc'],
        ]);

        $colleges = College::latest()->orderBy('college_name', 'asc')->get();
        $perpage = $request->input('perpage') ?: 25;
        $data = Course::with('college')->orderBy('course_name', 'asc');

        $search_keyword = request('search');

        // Search data
        if (request('search')) {
            $data->where(function ($data) use ($search_keyword) {
                $data
                    ->where('courses.course_name', 'like', '%' . request('search') . '%')
                    ->orWhere('courses.course_desc', 'like', '%' . request('search') . '%')
                    ->orwhereHas('college', function ($subq) use ($search_keyword) {
                        $subq->where(function ($subq2) use ($search_keyword) {
                            $subq2->orWhere('college_name', 'like', '%' . request('search') . '%');
                        });
                    });
            });
        }

        if (request()->has(['college'])) {
            $data->where(function ($data) use ($search_keyword) {
                $data
                    ->whereHas('college', function ($subq) use ($search_keyword) {
                        $subq->where(function ($subq2) use ($search_keyword) {
                            $subq2->orWhere('college_name', 'like', '%' . request('college') . '%');
                        });
                    });
            });
        }

        if (request()->has(['field', 'direction'])) {
            $data->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/Course/Index', [
            'courses' => $data->paginate($perpage)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction', 'perpage', 'college']),
            'colleges' => $colleges,
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
            'college' => ['required'],
            'course_name' => ['required', 'string', 'max:255', 'unique:courses'],
            'course_desc' => ['required', 'string', 'max:255'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        Course::create([
            'college_id' => $request['college']['id'],
            'course_name' => $request['course_name'],
            'course_desc' => $request['course_desc'],
        ]);

        $this->flash('Course added', 'success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {

        $val = Validator::make($request->all(), [
            'college' => ['required'],
            'course_name' => ['required', 'string', 'max:255'],
            'course_desc' => ['required', 'string', 'max:255'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $course->update([
            'college_id' => $request['college']['id'],
            'course_name' => $request['course_name'],
            'course_desc' => $request['course_desc'],
        ]);
        if ($val) {
            $this->flash('Course updated successfully.', 'success');
        }


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $d = Course::find($id);
        $d->delete();

        $this->flash('Course removed.', 'success');

        return redirect()->back();
    }
}
