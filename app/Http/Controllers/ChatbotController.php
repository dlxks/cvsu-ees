<?php

namespace App\Http\Controllers;

use App\Http\Traits\Banner;
use App\Imports\ChatbotsImport;
use App\Models\Chatbot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ChatbotController extends Controller
{
    use Banner;

    public function index(Request $request)
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:category,question,answer'],
        ]);

        $data = Chatbot::query();

        $perpage = $request->input('perpage') ?: 25;

        if (request('search')) {
            $data
                ->where('chatbots.category', 'like', '%' . request('search') . '%')
                ->orwhere('chatbots.question', 'like', '%' . request('search') . '%')
                ->orWhere('chatbots.answer', 'like', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $data->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/Chatbot/Index', [
            'concerns' => $data->paginate($perpage)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction', 'perpage']),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'category' => ['required', 'string'],
            'question' => ['required', 'string'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        Chatbot::create([
            'category' => $request['category'],
            'question' => Str::of($request['question'])->ucfirst(),
            'answer' => Str::of($request['answer'])->ucfirst(),
        ]);

        $this->flash('New question for chatbot added.', 'success');

        return redirect()->route('admin.chatbot.index');
    }

    public function show(Chatbot $chatbot)
    {
        //
    }

    public function edit(Chatbot $chatbot)
    {
        //
    }

    public function update(Request $request, Chatbot $chatbot)
    {
        $val = Validator::make($request->all(), [
            'category' => ['required'],
            'question' => ['required'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $chatbot->update([
            'category' => $request['category'],
            'question' => Str::of($request['question'])->ucfirst(),
            'answer' => Str::of($request['answer'])->ucfirst(),
        ]);

        $this->flash('Question updated!', 'success');

        return redirect()->route('admin.chatbot.index');
    }

    public function destroy($id)
    {
        $d = Chatbot::find($id);
        $d->delete();

        $this->flash('Question removed.', 'success');

        return redirect()->route('admin.chatbot.index');
    }

    public function import() 
    {
        Excel::import(new ChatbotsImport,request()->file('file'));
             
        return back();
    }
}
