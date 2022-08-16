<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CollegeController extends Controller
{
    use Banner;


    public function __construct()
    {
        $this->authorizeResource(College::class);
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
            'field' => ['in:college_name,college_desc'],
        ]);

        $query = College::orderBy('college_name', 'asc');
        $perpage = $request->input('perpage') ?: 10;

        if (request('search')) {
            $query->where('college_name', 'like', '%' . request('search') . '%')->orWhere('college_desc', 'like', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/College/Index', [

            'colleges' => $query->paginate($perpage)->withQueryString(),
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
            'college_name' => ['required', 'string', 'max:255', 'unique:colleges'],
            'college_desc' => ['required', 'string', 'max:255'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        College::create([
            'college_name' => $request['college_name'],
            'college_desc' => $request['college_desc'],
        ]);

        $this->flash('College created', 'success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function show(College $college)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function edit(College $college)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, College $college)
    {
        $val = Validator::make($request->all(), [
            'college_name' => ['required', 'string', 'max:255'],
            'college_desc' => ['required', 'string', 'max:255'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $college->update([
            'college_name' => $request['college_name'],
            'college_desc' => $request['college_desc'],
        ]);

        $this->flash('College updated successfully.', 'success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $d = College::find($id);
        $d->delete();

        $this->flash('College removed.', 'success');

        return redirect()->back();
    }
}
