<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\PasswordValidationRules;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Http\Traits\Banner;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    use Banner, PasswordValidationRules;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }
    
    public function index(Request $request)
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,email,phone'],
        ]);

        $query = User::query();

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%')->orWhere('email', 'like', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/User/Index', [

            'users' => $query->paginate(25)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction']),
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'integer', 'unique:users', 'regex:/^(63)[0-9]{10}$/'],
            'password' => $this->passwordRules(),
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'role' => $request['role'],
            'password' => Hash::make($request['password']),
        ]);

        $this->flash('User added', 'success');

        return redirect()->back();
        // return redirect()->route('users.index')->with('success', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $val = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'integer', 'regex:/^(63)[0-9]{10}$/'],
            // 'password' => $this->passwordRules(),000
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'role' => $request['role'],
            'password' => Hash::make($request['password']),
        ]);

        $this->flash('User information updated.', 'success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $d = User::find($id);
        $d->delete();

        $this->flash('User removed.', 'success');

        return redirect()->back();
    }

    public function usersExport()
    {
        if (request()->has('type')) {
            if (request()->get('type') == 'xlsx') {
                return Excel::download(new UsersExport, auth()->user()->name . '-users.xlsx');
            } elseif (request()->get('type') == 'csv') {
                return Excel::download(new UsersExport, auth()->user()->name . '-users.csv');
            }
        }

        return back();
    }

    protected function resourceAbilityMap()
    {
        return array_merge(parent::resourceAbilityMap(), ['usersExport' => 'usersExport']);
    }
}