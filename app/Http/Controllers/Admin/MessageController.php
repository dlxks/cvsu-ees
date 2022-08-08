<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MessagesExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\Banner;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class MessageController extends Controller
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
            'field' => ['in:inquiry,contact'],
        ]);

        $data = Message::orderBy('created_at', 'desc');

        $perpage = $request->input('perpage') ?: 25;

        if (request('search')) {
            $data
                ->orwhere('messages.name', 'like', '%' . request('search') . '%')
                ->orwhere('messages.inquiry', 'like', '%' . request('search') . '%')
                ->orWhere('messages.contact', 'like', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $data->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/Message/Index', [
            'messages' => $data->paginate($perpage)->withQueryString(),
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
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $d = Message::find($id);
        $d->delete();

        $this->flash('Message removed.', 'success');

        return redirect()->route('admin.messages.index');
    }

    // Export function
    public function export()
    {
        $date = Carbon::now()->format('d-m-Y');

        if (request()->has('type')) {
            if (request()->get('type') == 'xlsx') {
                return Excel::download(new MessagesExport, $date . '-inquiries.xlsx');
            } elseif (request()->get('type') == 'csv') {
                return Excel::download(new MessagesExport, $date . '-inquiries.csv');
            }
        }
        return back();
    }
}
